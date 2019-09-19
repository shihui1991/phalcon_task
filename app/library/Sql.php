<?php


class Sql
{

    /**
     * 生成插入或更新数据的sql
     *
     * @param string $table
     * @param array $data
     * @param string|array $updateFields 覆盖更新的字段
     * @param string|array $incrFields   增量更新的字段
     * @return bool|string
     */
    public static function insertOrUpdateSql($table, array $data, $updateFields = array(), $incrFields = array())
    {
        if(0 == count($data)){
            return false;
        }
        $sql = "insert into `$table` set ";
        # 数据字段
        foreach($data as $key => $val){
            $val = addslashes($val);
            $sql .= " `$key` = '$val',";
        }
        $sql = rtrim($sql,', ');
        # 更新字段
        if(empty($updateFields) && empty($incrFields)){
            return $sql;
        }
        $sql .= ' on duplicate key update ';
        $updateArr = array();
        # 覆盖更新的字段
        if(!empty($updateFields)){
            if(!is_array($updateFields)){
                $updateFields = array($updateFields);
            }
            foreach($updateFields as $field){
                $updateArr[] = " `$field` = values(`$field`) ";
            }
        }
        # 增量更新字段
        if(!empty($incrFields)){
            if(!is_array($incrFields)){
                $incrFields = array($incrFields);
            }
            foreach($incrFields as $field){
                $updateArr[] = " `{$field}` = `{$field}` + values(`{$field}`) ";
            }
        }
        $sql .= implode(',',$updateArr);

        return $sql;
    }

    /**
     * 批量 更新或插入数据的sql
     *
     * @param string $table         数据表名
     * @param array $inserts        数据字段
     * @param array $values         原始数据
     * @param array|string $updates 覆盖更新字段
     * @param array|string $incrs   增量更新字段
     * @return bool|array          返回false(条件不符)，返回array(sql语句)
     */
    public static function batchInsertOrUpdateSql($table='', $values=array(), $inserts=array(), $updates=array(), $incrs=array()){
        if(empty($table) || empty($inserts) || empty($values)){
            return false;
        }
        if(!empty($updates)){
            // 数据字段必须包含覆盖更新字段
            $checked = Arr::checkIsInList($updates, $inserts);
            if(false == $checked){
                return false;
            }
        }
        if(!empty($incrs)){
            // 数据字段必须包含增量更新字段
            $checked = Arr::checkIsInList($incrs, $inserts);
            if(false == $checked){
                return false;
            }
        }

        //数据字段
        $sql_inserts=array();
        foreach ($inserts as $insert){
            $sql_inserts[]=" `$insert` ";
        }
        $sql_inserts=implode(',',$sql_inserts);
        //数据分页
        $num=100;
        $page_values=array();
        $values=array_values($values);
        $count = count($values);
        for($i=0;$i<$count;$i++){
            $p=ceil(($i+1)/$num);
            $temp_values=array();
            foreach ($inserts as $insert){
                $temp=isset($values[$i][$insert]) && !is_null($values[$i][$insert])?(string)$values[$i][$insert]:null;
                $temp = addslashes($temp);
                $temp_values[]=" '$temp' ";
            }
            $temp_values=implode(',',$temp_values);
            $page_values[$p][]=" ($temp_values) ";
        }
        $updateSql = '';
        if(!empty($updates) || !empty($incrs)){
            $updateSql = ' on duplicate key update ';
        }
        $sql_updates=array();
        // 覆盖更新的字段
        if(!empty($updates)){
            if(is_string($updates)){
                $sql_updates[] = " `$updates` = values(`$updates`) ";
            }else{
                foreach ($updates as $update){
                    $sql_updates[] = " `$update` = values(`$update`) ";
                }
            }
        }
        // 增量更新字段
        if(!empty($incrs)){
            if(is_string($incrs)){
                $sql_updates[]= " `{$incrs}` = `{$incrs}` + values(`{$incrs}`) ";
            }else{
                foreach ($incrs as $incr){
                    $sql_updates[]= " `{$incr}` = `{$incr}` + values(`{$incr}`) ";
                }
            }
        }
        $updateSql .= implode(',',$sql_updates);

        // 生成sql
        $sqls=array();
        for($i=0;$i<$p;$i++){
            $sql_values=implode(',',$page_values[$i+1]);
            $sqls[$i]="insert into `$table` ($sql_inserts) values $sql_values $updateSql";
        }
        return $sqls;
    }

    /**
     * 虚拟表批量更新数据 sql
     *
     * @param string $table         数据表名
     * @param array $inserts        数据字段
     * @param array $values         原始数据
     * @param array|string $updates  更新字段
     * @param array|string $wheres   条件字段
     * @return bool|array          返回false(条件不符)，返回array(sql语句)
     */
    public static function batchUpdateSql($table='', $values=array(), $inserts=array(), $updates=array(), $wheres='Id'){
        if(empty($table) || empty($inserts) || empty($values) || empty($updates) || empty($wheres)){
            return false;
        }
        // 数据字段必须包含更新字段
        $checked = Arr::checkIsInList($updates, $inserts);
        if(false == $checked){
            return false;
        }
        // 数据字段必须包含条件字段
        $checked = Arr::checkIsInList($wheres, $inserts);
        if(false == $checked){
            return false;
        }

        //数据字段
        $sql_inserts=array();
        foreach ($inserts as $insert){
            $sql_inserts[]=" `$insert` ";
        }
        $sql_inserts=implode(',',$sql_inserts);
        /* ++++++++++ 创建虚拟表 ++++++++++ */
        //创建虚拟表 表名
        $temp_table=" `{$table}_temp` ";
        //创建虚拟表 sql
        $sqls[] = " create temporary table $temp_table as ( select $sql_inserts from `$table` where 1<>1 ) ";
        /* ++++++++++ 添加数据 ++++++++++ */
        //数据分页
        $num=100;
        $page_values=array();
        $values=array_values($values);
        $count = count($values);
        for($i=0;$i<$count;$i++){
            $p=ceil(($i+1)/$num);
            $temp_values=array();
            foreach ($inserts as $insert){
                $temp=isset($values[$i][$insert]) && !is_null($values[$i][$insert])?(string)$values[$i][$insert]:null;
                $temp = addslashes($temp);
                $temp_values[]=" '$temp' ";
            }
            $temp_values=implode(',',$temp_values);
            $page_values[$p][]=" ($temp_values) ";
        }
        //插入数据 sql
        for($i=0;$i<$p;$i++){
            $sql_values=implode(',',$page_values[$i+1]);
            $sqls[]=" insert into $temp_table ($sql_inserts) values $sql_values ";
        }
        /* ++++++++++ 批量更新 ++++++++++ */
        //更新字段
        if(is_string($updates)){
            $sql_updates= " `$table`.`$updates` = $temp_table.`$updates` ";
        }else{
            $sql_updates=array();
            foreach ($updates as $update){
                $sql_updates[] = " `$table`.`$update` = $temp_table.`$update` ";
            }
            $sql_updates=implode(',',$sql_updates);
        }
        //条件字段
        if(is_string($wheres)){
            $sql_wheres= " `$table`.`$wheres` = $temp_table.`$wheres` ";
        }else{
            $sql_wheres=array();
            foreach ($wheres as $where){
                $sql_wheres[] = " `$table`.`$where` = $temp_table.`$where` ";
            }
            $sql_wheres=implode(' and ',$sql_wheres);
        }
        //更新数据 sql
        $sqls[]="update `$table` , $temp_table set $sql_updates where $sql_wheres ";
        return $sqls;
    }


    /**
     * 绑定数据
     *
     * @param $sql
     * @param array $params
     * @return mixed
     */
    public static function bind($sql, $params = [])
    {
        foreach($params as $key => $val){
            $sql = str_replace(':'.$key.':',$val,$sql);
        }

        return $sql;
    }
}