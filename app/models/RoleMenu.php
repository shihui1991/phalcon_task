<?php

class RoleMenu extends ModelInit
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("role_menu");

        $this->belongsTo('role_id','Role','id');
        $this->belongsTo('menu_id','Menu','id');
    }

    public $role_id;
    public $menu_id;

    /**
     * 字段
     *
     * @return array
     */
    public static function columns()
    {
        return [
            'role_id' => ['label' => '角色ID', 'attr' => 'int',],
            'menu_id' => ['label' => '菜单ID', 'attr' => 'int',],
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
            'role_id.integer' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\d{1,10}$/','message' => '角色ID 必须是1 ~ 10 位的整数']],
            'menu_id.integer' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\d{1,10}$/','message' => '菜单ID 必须是1 ~ 10 位的整数']],
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
