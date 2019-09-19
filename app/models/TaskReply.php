<?php

class TaskReply extends ModelInit
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("task_reply");

        $this->belongsTo('task_id','Task','id');
        $this->belongsTo('user_id','User','id');
        $this->belongsTo('to_user_id','User','id',['alias' => 'toUser']);
        $this->belongsTo('parent_id','TaskReply','id',['alias' => 'prevReply']);
    }

    public $id;
    public $parent_id;
    public $task_id;
    public $user_id;
    public $to_user_id;
    public $content;
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
            'parent_id' => ['label' => '上一条ID', 'attr' => 'int',],
            'task_id' => ['label' => '任务ID', 'attr' => 'int',],
            'user_id' => ['label' => '人员ID', 'attr' => 'int',],
            'to_user_id' => ['label' => '接收人员ID', 'attr' => 'int',],
            'content' => ['label' => '回复内容', 'attr' => 'string',],
            'status' => ['label' => '状态', 'attr' => 'int',],
            'created_at' => ['label' => '回复时间', 'attr' => 'int',],
            'updated_at' => ['label' => '修改时间', 'attr' => 'int',],
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
            'show' => [
                'edit' => ['content','status','updated_at']
            ],
            'hide' => [
                'add' => ['id']
            ],
        ];
    }

    # 状态
    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

    /**
     * 数值描述
     *
     * @return array
     */
    public static function valueDescs()
    {
        return [
            'status' => [static::STATUS_UNREAD => '未读', static::STATUS_READ => '已读'],
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
            'parent_id.integer' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\d{1,10}$/','message' => '上条ID 必须是1 ~ 10 位的整数']],
            'task_id.integer' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\d{1,10}$/','message' => '任务ID 必须是1 ~ 10 位的整数']],
            'user_id.integer' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\d{1,10}$/','message' => '人员ID 必须是1 ~ 10 位的整数']],
            'to_user_id.integer' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\d{1,10}$/','message' => '接收人员ID 必须是1 ~ 10 位的整数']],
            'content.required' => [\Phalcon\Validation\Validator\PresenceOf::class, ['message' => '内容 必须']],
            'status.in' => [\Phalcon\Validation\Validator\InclusionIn::class, ['domain' => array_keys(static::getValueDescForField('status')), 'message' => '状态 选用指定范围的值']]
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
            'add' => ['parent_id.integer','task_id.integer','user_id.integer','to_user_id.integer','content.required','status.in'],
            'edit' => ['content.required','status.in'],
        ];
    }

    /**
     * 获取未读条数
     *
     * @param $userId
     * @return mixed
     */
    public function getUnreadCount($userId)
    {
        return static::count("to_user_id = {$userId} AND status = ".static::STATUS_UNREAD);
    }
}
