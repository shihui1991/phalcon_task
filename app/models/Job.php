<?php

class Job extends ModelInit
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("task_v2");
        $this->setSource("job");
    }

    public $id;
    public $title;
    public $start_at;
    public $status;
    public $develop;
    public $days;
    public $difficult_level;
    public $pro_vali;
    public $finish_at;
    public $handle;
    public $priority;
    public $version;
    public $grade;
    public $require_vali;
    public $test;

    /**
     * 字段
     *
     * @return array
     */
    public static function columns()
    {
        return [
            'id' => ['label' => 'ID', 'attr' => 'int',],
            'title' => ['label' => '标题', 'attr' => 'string',],
            'start_at' => ['label' => '预计开始', 'attr' => 'string',],
            'status' => ['label' => '状态', 'attr' => 'int',],
            'develop' => ['label' => '开发人员', 'attr' => 'string',],
            'days' => ['label' => '天数', 'attr' => 'float',],
            'difficult_level' => ['label' => '难度', 'attr' => 'int',],
            'pro_vali' => ['label' => '专业验证', 'attr' => 'int',],
            'finish_at' => ['label' => '预计结束', 'attr' => 'string',],
            'handle' => ['label' => '处理人', 'attr' => 'string',],
            'priority' => ['label' => '优先级', 'attr' => 'string',],
            'version' => ['label' => '迭代', 'attr' => 'string',],
            'grade' => ['label' => '评价', 'attr' => 'int',],
            'require_vali' => ['label' => '需求验证', 'attr' => 'int',],
            'test' => ['label' => '测试', 'attr' => 'string',],
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

    # 状态
    const STATUS_PLAN = 0;
    const STATUS_WORKING = 1;
    const STATUS_FINISH = 2;
    const STATUS_DENY = 3;
    # 评价
    const GRADE_GOOD = 1;
    const GRADE_NORMAL = 2;
    const GRADE_BAD = 3;

    /**
     * 数值描述
     *
     * @return array
     */
    public static function valueDescs()
    {
        return [
            'status' => [
                static::STATUS_PLAN    => '规划中',
                static::STATUS_WORKING => '实现中',
                static::STATUS_FINISH  => '已实现',
                static::STATUS_DENY    => '已拒绝',
            ],
            'grade' => [
                static::GRADE_GOOD   => '好',
                static::GRADE_NORMAL => '中',
                static::GRADE_BAD    => '差',
            ],
            'require_vali' => [
                static::GRADE_GOOD   => '好',
                static::GRADE_NORMAL => '中',
                static::GRADE_BAD    => '差',
            ],
            'pro_vali' => [
                static::GRADE_GOOD   => '好',
                static::GRADE_NORMAL => '中',
                static::GRADE_BAD    => '差',
            ],
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
            'title.length' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\S{1,255}$/','message' => '名称 长度 1~255 位']],
            'status.in' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\S{1,255}$/','message' => '名称 长度 1~255 位']],
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
            'add' => [],
        ];
    }
}
