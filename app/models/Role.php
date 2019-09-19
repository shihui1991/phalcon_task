<?php

class Role extends ModelInit
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("role");

        $this->hasMany('id','RoleMenu','role_id');
        $this->hasManyToMany('id','RoleMenu','role_id','menu_id','Menu','id');
    }

    public $id;
    public $parent_id;
    public $name;
    public $is_root;
    public $status;
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
            'is_root' => ['label' => '是否超管', 'attr' => 'int',],
            'status' => ['label' => '状态', 'attr' => 'int',],
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

    # 是否超管
    const IS_ROOT_NO = 0;
    const IS_ROOT_YES = 1;
    # 状态
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    /**
     * 数值描述
     *
     * @return array
     */
    public static function valueDescs()
    {
        return [
            'is_root' => [static::IS_ROOT_NO => '否', static::IS_ROOT_YES => '是', ],
            'status' => [static::STATUS_ON => '开启', static::STATUS_OFF => '禁用',],
        ];
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
            'is_root.in' => [\Phalcon\Validation\Validator\InclusionIn::class,['domain'=>array_keys(static::getValueDescForField('is_root')),'message' => '是否超管 选用指定范围的值']],
            'status.in' => [\Phalcon\Validation\Validator\InclusionIn::class,['domain'=>array_keys(static::getValueDescForField('status')),'message' => '状态 选用指定范围的值']],
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
            'add' => ['parent_id.integer','name.length','name.unique','is_root.in','status.in'],
            'edit' => ['parent_id.integer','name.length','name.unique','is_root.in','status.in'],
        ];
    }
}
