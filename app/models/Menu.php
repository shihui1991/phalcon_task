<?php

class Menu extends ModelInit
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("menu");
    }

    public $id;
    public $parent_id;
    public $name;
    public $infos;
    public $uri;
    public $is_ctrl;
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
            'infos' => ['label' => '描述', 'attr' => 'string',],
            'uri' => ['label' => '路由', 'attr' => 'string',],
            'is_ctrl' => ['label' => '是否限制', 'attr' => 'int',],
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

    # 是否限制
    const IS_CTRL_NO = 0;
    const IS_CTRL_YES = 1;
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
            'is_ctrl' => [static::IS_CTRL_YES => '限制', static::IS_CTRL_NO => '不限',],
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
            'infos.length' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\S{0,255}$/','message' => '描述 长度不超过 255 位','allowEmpty' => true]],
            'uri.length' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\S{1,255}$/','message' => '路由 长度 1~255 位']],
            'uri.unique' => [\Phalcon\Validation\Validator\Uniqueness::class,['model'=>$this,'message' => '路由 已存在']],
            'is_ctrl.in' => [\Phalcon\Validation\Validator\InclusionIn::class,['domain'=>array_keys(static::getValueDescForField('is_ctrl')),'message' => '是否限制 选用指定范围的值']],
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
            'add' => ['parent_id.integer','name.length','infos.length','uri.length','uri.unique','is_ctrl.in','status.in'],
            'edit' => ['parent_id.integer','name.length','infos.length','uri.length','uri.unique','is_ctrl.in','status.in'],
        ];
    }
}
