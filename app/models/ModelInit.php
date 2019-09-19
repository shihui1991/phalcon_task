<?php
/*
 * 模型基类
 * */

class ModelInit extends \Phalcon\Mvc\Model
{
    use StaticInstance;
    use ModelTrait;

    /**
     * 保存之前
     */
    public function beforeSave()
    {
        $this->formatForSave();
        $this->handleBeforeSave();
    }

    /**
     * 查询之后
     */
    public function afterFetch()
    {
        $this->formatForGet();
    }

    /**
     * 保存之后
     */
    public function afterSave()
    {
        $this->formatForGet();
    }

    /**
     * 重写保存
     *
     * @param null $data
     * @param null $whiteList
     * @return bool
     */
    public function save($data = null, $whiteList = null)
    {
        $this->beforeSave();
        $res = parent::save($data,$whiteList);
        if($res) $this->afterSave();

        return $res;
    }

    /**
     * 通用验证
     *
     * @param $method
     * @param $data
     * @return \Phalcon\Validation\Message\Group
     */
    public function validateForMethod($method, $data = [])
    {
        # 获取验证规则
        $rules = $this->getRulesForGroup($method);
        # 添加验证器
        $validation = new \Phalcon\Validation();
        foreach ($rules as $name => $rule) {
            $name = explode('.', $name);
            $field = $name[0];
            $class = $rule[0];
            $rule[1]['cancelOnFail'] = true;
            $validator = new $class($rule[1]);
            # unique 多字段索引唯一
            if('unique' == $name[1] && isset($rule[2])){
                $field = $rule[2];
            }
            $validation->add($field, $validator);
        }
        # 验证
        $data = empty($data) ? $this : $data;
        $msgs = $validation->validate($data);

        return $msgs;
    }

    /**
     * 在保存之前的处理
     */
    public function handleBeforeSave(){}

    /**
     * 保存
     *
     * @param $input
     * @param $method
     * @return bool|\Phalcon\Validation\Message\Group
     */
    public function handleSave($input, $method)
    {
        # 批量填充
        $filled = $this->batchFill($input, $method);
        # 数据验证
        $msgs = $this->validateForMethod($method, $filled);
        if (count($msgs)) {
            return $msgs;
        }
        # 保存
        $res = $this->save();

        return $res;
    }

    /**
     * 添加或修改
     *
     * @param $data
     * @param array $updateFields
     * @param array $incrFields
     * @return \Phalcon\Mvc\Model\QueryInterface|bool
     */
    public function insertOrUpdate($data, $updateFields = [], $incrFields = [])
    {
        $sql = Sql::insertOrUpdateSql($this->getSource(),$data,$updateFields,$incrFields);
        if( !$sql){
            return false;
        }
        $db = $this->getDI()->get('db');
        $res = $db->execute($sql);

        return $res;
    }

    /**
     * 批量添加或修改
     *
     * @param $list
     * @param array $insertFields
     * @param array $updateFields
     * @param array $incrFields
     * @return bool
     */
    public function batchInsertOrUpdate($list, $insertFields = [], $updateFields = [], $incrFields = [])
    {
        if(empty($insertFields)){
            $insertFields = array_keys($list[0]);
        }
        $sqls = Sql::batchInsertOrUpdateSql($this->getSource(),$list,$insertFields,$updateFields,$incrFields);
        if( ! $sqls){
            return false;
        }
        $db = $this->getDI()->get('db');
        foreach($sqls as $sql){
            $res = $db->execute($sql);
        }

        return $res;
    }

    /** 批量更新
     * @param $list
     * @param array $insertFields
     * @param array $updateFields
     * @param string $whereFields
     * @return bool
     */
    public function batchUpdate($list, $insertFields = [], $updateFields = [], $whereFields = 'id')
    {
        if(empty($insertFields)){
            $insertFields = array_keys($list[0]);
        }
        if(empty($updateFields)){
            $updateFields = $insertFields;
        }
        $sqls = Sql::batchUpdateSql($this->getSource(),$list,$insertFields,$updateFields,$whereFields);
        if( ! $sqls){
            return false;
        }
        $db = $this->getDI()->get('db');
        foreach($sqls as $sql){
            $res = $db->execute($sql);
        }

        return $res;
    }

    /**
     * 获取指定ID的列表
     *
     * @param $ids
     * @return array|\Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getListInIds($ids)
    {
        $list = static::query()->inWhere('id',$ids)->execute();

        return empty($list) ? [] : $list;
    }
}