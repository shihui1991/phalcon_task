<?php

class UserRole extends ModelInit
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("user_role");

        $this->belongsTo('user_id','User','id');
        $this->belongsTo('role_id','Role','id');
    }

    public $user_id;
    public $role_id;

    /**
     * 字段
     *
     * @return array
     */
    public static function columns()
    {
        return [
            'user_id' => ['label' => '职员ID', 'attr' => 'int',],
            'role_id' => ['label' => '角色ID', 'attr' => 'int',],
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
            'hide' => [],
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
            'user_id.integer' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\d{1,10}$/','message' => '职员ID 必须是1 ~ 10 位的整数']],
            'role_id.integer' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\d{1,10}$/','message' => '角色ID 必须是1 ~ 10 位的整数']],
        ];
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
}
