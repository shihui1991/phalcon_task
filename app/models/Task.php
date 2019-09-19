<?php

class Task extends ModelInit
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("task");
    }

    public $id;
    public $date;
    public $user_id;
    public $task;
    public $next_task;
    public $issues;
    public $mark;
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
            'date' => ['label' => '日期', 'attr' => 'string',],
            'user_id' => ['label' => '人员ID', 'attr' => 'int',],
            'task' => ['label' => '今日任务', 'attr' => 'string',],
            'next_task' => ['label' => '明日任务', 'attr' => 'string',],
            'issues' => ['label' => '问题与建议', 'attr' => 'string',],
            'mark' => ['label' => '备注', 'attr' => 'string',],
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
                'store' => ['id'],
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
            'id.integer' => [\Phalcon\Validation\Validator\Regex::class, ['pattern' => '/^\d{1,10}$/', 'message' => 'ID 必须是1 ~ 10 位的整数']],
            'date.date' => [\Phalcon\Validation\Validator\Date::class, ['format' => 'Y-m-d', 'message' => '日期 格式错误']],
            'date.unique' => [\Phalcon\Validation\Validator\Uniqueness::class,['model'=>$this,'message' => '当日任务已上报'],['date','user_id']],
            'user_id.integer' => [\Phalcon\Validation\Validator\Regex::class, ['pattern' => '/^\d{1,10}$/', 'message' => '人员 必须是1 ~ 10 位的整数']],
            'task.length' => [\Phalcon\Validation\Validator\Regex::class, ['pattern' => '/^[\S ]{1,255}$/', 'message' => '名称 长度不超过 255 位']],
            'next_task.length' => [\Phalcon\Validation\Validator\Regex::class, ['pattern' => '/^[\S ]{0,255}$/', 'message' => '明日任务 长度不超过 255 位','allowEmpty' => true]],
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
            'store' => ['date.date','user_id.integer','task.length','next_task.length'],
        ];
    }
}
