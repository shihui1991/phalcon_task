<?php

class Account extends ModelInit
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("performance_appraisal");
        $this->setSource("USERS");

        $this->hasOne('ID','User','id');
    }

    public $ID;
    public $EMPLOYEE_NAME;
    public $ACCESS_TOKEN;

    /**
     * 字段
     *
     * @return array
     */
    public static function columns()
    {
        return [
            'ID' => ['label' => 'ID', 'attr' => 'int',],
            'EMPLOYEE_NAME' => ['label' => '姓名', 'attr' => 'string',],
            'ACCESS_TOKEN' => ['label' => '登录令牌', 'attr' => 'string',],
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
