<?php

trait ModelTrait
{

    /**
     * 字段
     *
     * @return array
     */
    public static function columns()
    {
        return [
            'id' => [
                'field' => 'id',
                'label' => 'ID',
                'attr' => 'int',
            ],
        ];
    }

    /**
     * 获取字段名称
     *
     * @param $field
     * @return mixed
     */
    public static function getLabelForField($field)
    {
        $columns = static::columns();

        return isset($columns[$field]) ? $columns[$field]['label'] : $field;
    }

    /**
     * 字段分组
     *
     * @return array
     */
    public static function fieldsGroup()
    {
        return [
            'show' => [],
            'hide' => [],
        ];
    }

    /**
     * 获取分组内的字段
     *
     * @param null $key
     * @return array
     */
    public static function getFieldsForGroup($key = null)
    {
        $group = static::fieldsGroup();
        # 可用的字段
        if(isset($group['show'][$key])){
            return $group['show'][$key];
        }
        # 全部
        $all = array_Keys(static::columns());
        if( ! isset($group['hide'][$key])){
            return $all;
        }
        # 过滤不可用的字段
        $fields = [];
        foreach($all as $field){
            if(in_array($field,$group['hide'][$key])) continue;
            $fields[] = $field;
        }

        return $fields;
    }

    /**
     * 数值描述
     *
     * @return array
     */
    public static function valueDescs()
    {
        return [];
    }

    /**
     * 获取字段的数值描述
     *
     * @param $field
     * @param null $val
     * @return array|string
     */
    public static function getValueDescForField($field, $val = null)
    {
        $descs = static::valueDescs();
        if( ! isset($descs[$field])) return $val;
        $fieldDescs = $descs[$field];

        return !is_null($fieldDescs) && isset($fieldDescs[$val]) ?$fieldDescs[$val] : $fieldDescs;
    }

    /**
     * 批量填充输入数据
     *
     * @param array $input
     * @param $group
     * @param bool $isSkipNull
     * @return array
     */
    public function batchFill(array $input, $group, $isSkipNull = false)
    {
        if(empty($input) && $isSkipNull) return [];
        $fields = static::getFieldsForGroup($group);
        $filled = [];
        foreach($fields as $field){
            $val = isset($input[$field]) ? trim($input[$field]) : null;
            $filled[$field] = $val;
            if($isSkipNull && is_null($val)) continue;
            $this->$field = $val;
        }

        return $filled;
    }

    /**
     * 保存前批量格式化
     *
     * @param bool $isFill
     */
    public function formatForSave($isFill = true)
    {
        $columns = static::columns();
        foreach ($this as $field => $value) {
            if ( ! isset($columns[$field])) continue;
            if (! $isFill && is_null($value)) continue;
            $method = 'set' . \Phalcon\Text::camelize($field);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }else{
                $this->$field = AttrFormatter::handle('set',$columns[$field]['attr'],$value);
            }
        }
    }

    /**
     * 获取前批量格式化
     *
     * @return array
     */
    public function formatForGet()
    {
        $columns = static::columns();
        $origin = [];
        foreach ($this as $field => $value) {
            if ( ! isset($columns[$field])) continue;
            $origin[$field] = $value;
            $method = 'get' . \Phalcon\Text::camelize($field);
            if (method_exists($this, $method)) {
                $value = $this->$method();
            }else{
                $value = AttrFormatter::handle('get',$columns[$field]['attr'],$value);
            }
            $this->$field = $value;
        }

        return $origin;
    }

    /**
     * 验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * 验证规则分组
     *
     * @return array
     */
    public static function rulesGroup()
    {
        return [];
    }

    /**
     * 获取分组内的验证规则
     *
     * @param null $key
     * @return array
     */
    public function getRulesForGroup($key = null)
    {
        $groups = static::rulesGroup();
        $rules = $this->rules();
        if (is_null($key) || !isset($groups[$key])) return $rules;
        $select = [];
        foreach ($groups[$key] as $name) {
            $select[$name] = $rules[$name];
        }

        return $select;
    }
}