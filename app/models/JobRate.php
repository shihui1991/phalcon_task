<?php

class JobRate extends ModelInit
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("job_rate");
    }

    public $id;
    public $skill_type;
    public $job_level;
    public $difficulty_level;
    public $rate;

    /**
     * 字段
     *
     * @return array
     */
    public static function columns()
    {
        return [
            'id' => ['label' => 'ID', 'attr' => 'string',],
            'skill_type' => ['label' => '技术类别', 'attr' => 'int',],
            'job_level' => ['label' => '职级', 'attr' => 'int',],
            'difficulty_level' => ['label' => '难度级别', 'attr' => 'int',],
            'rate' => ['label' => '难度系数', 'attr' => 'int',],
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

    # 技术类别
    const SKILL_TYPE_PROGRAM = 1;
    const SKILL_TYPE_ART = 2;
    const SKILL_TYPE_PLAN = 3;
    # 职级
    const JOB_LEVEL_PRIMARY = 1;
    const JOB_LEVEL_MIDDLE = 2;
    const JOB_LEVEL_SENIOR = 3;
    const JOB_LEVEL_MAIN = 4;
    # 最大难度级别
    const DIFFICULTY_LEVEL_MAX = 9;

    /**
     * 数值描述
     *
     * @return array
     */
    public static function valueDescs()
    {
        return [
            'skill_type' => [
                static::SKILL_TYPE_PROGRAM => '程序',
                static::SKILL_TYPE_ART => '美术',
                static::SKILL_TYPE_PLAN => '策划',
            ],
            'job_level' => [
                static::JOB_LEVEL_PRIMARY => '初级',
                static::JOB_LEVEL_MIDDLE => '中级',
                static::JOB_LEVEL_SENIOR => '高级',
                static::JOB_LEVEL_MAIN => '主级',
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
            'skill_type.in' => [\Phalcon\Validation\Validator\InclusionIn::class,['domain'=>array_keys(static::getValueDescForField('skill_type')),'message' => '技术类别 选用指定范围的值']],
            'job_level.in' => [\Phalcon\Validation\Validator\InclusionIn::class,['domain'=>array_keys(static::getValueDescForField('job_level')),'message' => '职级 选用指定范围的值']],
            'difficulty_level.integer' => [\Phalcon\Validation\Validator\Between::class,['minimum'=>1,'maximum'=>static::DIFFICULTY_LEVEL_MAX,'message' => '难度级别 必须在 1~'.static::DIFFICULTY_LEVEL_MAX.' 之间']],
            'rate.between' => [\Phalcon\Validation\Validator\Between::class,['minimum'=>1,'maximum'=>999,'message' => '难度系数 必须在 1~999 之间']],
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
            'store' => ['skill_type.in','job_level.in','difficulty_level.integer','rate.between'],
        ];
    }

    /**
     * 获取初始化的难度系数树表
     *
     * @return array
     */
    public function initJobRateTree()
    {
        $difficulties = array_fill(1,static::DIFFICULTY_LEVEL_MAX,'');
        $jobLevels = array_fill_keys(array_keys(static::getValueDescForField('job_level')),$difficulties);
        return array_fill_keys(array_keys(static::getValueDescForField('skill_type')),$jobLevels);
    }

    /**
     * 获取难度系数列表
     *
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getJobRateList()
    {
        return static::find(['order' => 'skill_type DESC,job_level DESC,difficulty_level DESC']);
    }

    /**
     * 获取难度系数树表
     *
     * @return array
     */
    public function getJobRateTree()
    {
        $tree = static::initJobRateTree();
        $list = static::getJobRateList();
        if(! $list) return $tree;
        foreach($list as $row){
            if(! isset($tree[$row->skill_type][$row->job_level][$row->difficulty_level])) continue;
            $tree[$row->skill_type][$row->job_level][$row->difficulty_level] = $row->rate;
        }

        return $tree;
    }

    /**
     * 获取难度系数树列表
     *
     * @return array
     */
    public function getJobRateTreeList()
    {
        $list = static::initJobRateTreeList();
        $origin = static::getJobRateList();
        if(! $origin){
            goto resp;
        }
        foreach($origin as $row){
            if(! isset($list[$row->id])) continue;
            $list[$row->id] = $row->rate;
        }

        resp:
        return $list;
    }

    /**
     * 初始化难度系数树列表
     *
     * @return array
     */
    public function initJobRateTreeList()
    {
        $list = [];
        foreach(static::getValueDescForField('skill_type') as $type => $typeName){
            foreach(static::getValueDescForField('job_level') as $level => $levelName){
                for($dif = 1; $dif <= static::DIFFICULTY_LEVEL_MAX; $dif ++){
                    $key = $type.'-'.$level.'-'.$dif;
                    $list[$key] = '';
                }
            }
        }

        return $list;
    }
}
