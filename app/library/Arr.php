<?php
/*
 * 数组或对象处理类
 * */

class Arr
{
    /**
     * 数组迭代器
     *
     * @param array $array
     * @return ArrayIterator
     */
    public static function makeArrayIterator($array = array())
    {
        return (new \ArrayObject($array))->getIterator();
    }

    /**
     * 下级分组
     *
     * @param $list
     * @param int $parentId
     * @param string $pIdKey
     * @return array
     */
    public static function getChildGroup($list, $parentId = 0, $pIdKey = 'parent_id')
    {
        $last = $child = [];
        if(empty($list)){
            goto result;
        }
        foreach(static::makeArrayIterator($list) as $i => $row){
            if($row[$pIdKey] == $parentId){
                $child[] = $row;
            }else{
                $last[] = $row;
            }
        }

        result:
        return [
            'child' => $child,
            'last' => $last,
        ];
    }

    /**
     * 检查元素是否包含于列表中
     *
     * @param mixed $check
     * @param array $list
     * @return bool
     */
    public static function checkIsInList($check, array $list)
    {
        if( ! is_array($check)){
            return in_array($check, $list);
        }
        $common = array_intersect($check, $list);
        sort($common);
        sort($check);

        return $common == $check;
    }

    /**
     * 生成树顺序列表
     *
     * @param array $list
     * @param int $parentId
     * @param int $level
     * @param string $pIdKey
     * @param string $idKey
     * @return array
     */
    public static function makeTreeOrderList(array $list, $parentId = 0, $level = 1, $pIdKey = 'parent_id', $idKey = 'id')
    {
        $treeList = [];
        foreach(static::makeArrayIterator($list) as $row){
            if($row[$pIdKey] != $parentId) continue;
            $row['tree_level'] = $level;
            $treeList[] = $row;
            $temp = static::makeTreeOrderList($list, $row[$idKey],$level + 1, $pIdKey, $idKey);
            if(! empty($temp)) $treeList = array_merge($treeList,$temp);
        }

        return $treeList;
    }
}