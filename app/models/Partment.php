<?php

class Partment extends ModelInit
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("partment");
    }

    public $id;
    public $parent_id;
    public $name;
    public $created_at;
    public $updated_at;

    /**
     * @param $created_at
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at ?? time();
        
        return $this;
    }

    /**
     * @param $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = time();

        return $this;
    }

    /**
     * 字段
     *
     * @return array
     */
    public static function columns()
    {
        return [
            'id' => ['label' => 'ID', 'attr' => 'int',],
            'parent_id' => ['label' => '上级ID', 'attr' => 'int',],
            'name' => ['label' => '名称', 'attr' => 'string',],
            'created_at' => ['label' => '创建时间', 'attr' => 'int',],
            'updated_at' => ['label' => '更新时间', 'attr' => 'int',],
        ];
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
            'hide' => [
                'add' => ['id'],
                'edit' => ['id', 'created_at', ],
            ],
        ];
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
     * 验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id.integer' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\d{1,10}$/','message' => 'ID 必须是1 ~ 10 位的整数']],
            'parent_id.integer' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\d{1,10}$/','message' => '上级ID 必须是1 ~ 10 位的整数']],
            'name.length' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\S{1,255}$/','message' => '名称 长度 1~255 位']],
            'name.unique' => [\Phalcon\Validation\Validator\Uniqueness::class,['model'=>$this,'message' => '名称 已存在']],
        ];
    }

    /**
     * 验证规则分组
     *
     * @return array
     */
    public static function rulesGroup()
    {
        return [
            'add' => ['parent_id.integer','name.length','name.unique'],
            'edit' => ['parent_id.integer','name.length','name.unique'],
        ];
    }
}
