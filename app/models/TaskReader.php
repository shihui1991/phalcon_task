<?php

class TaskReader extends ModelInit
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("task_reader");

        $this->belongsTo('task_id','Task','id');
        $this->belongsTo('user_id','User','id');
    }

    public $task_id;
    public $user_id;
    public $created_at;

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
     * 字段
     *
     * @return array
     */
    public static function columns()
    {
        return [
            'task_id' => ['label' => '任务ID', 'attr' => 'int',],
            'user_id' => ['label' => '人员ID', 'attr' => 'int',],
            'created_at' => ['label' => '标记时间', 'attr' => 'int',],
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
            'task_id.integer' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\d{1,10}$/','message' => '任务ID 必须是1 ~ 10 位的整数']],
            'user_id.integer' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\d{1,10}$/','message' => '人员ID 必须是1 ~ 10 位的整数']],
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

    /**
     * 获取任务已标记阅读的人数
     *
     * @param $taskId
     * @return mixed
     */
    public function getTaskReaderCount($taskId)
    {
        return static::count("task_id = {$taskId}");
    }

    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

    /**
     * 检验任务标记阅读状态
     *
     * @param $taskId
     * @return int
     */
    public function checkTaskReaderStatus($taskId)
    {
        $count = static::getTaskReaderCount($taskId);
        return $count > 0 ? static::STATUS_READ : static::STATUS_UNREAD;
    }
}
