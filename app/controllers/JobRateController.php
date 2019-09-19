<?php

class JobRateController extends ControllerAuth
{
    protected $modelClass = JobRate::class;

    /**
     * 列表
     */
    public function indexAction()
    {
        $tree = $this->model->getJobRateTreeList();
        Output::json($tree,'');
    }

    /**
     * 保存
     */
    public function storeAction()
    {
        $input = $this->get('input',null,[]);
        if(empty($input)){
            Output::json([],'请提供数据',412);
        }
        $list = [];
        $skillTypes = JobRate::getValueDescForField('skill_type');
        $jobLevels = JobRate::getValueDescForField('job_level');
        foreach($skillTypes as $type => $typeName){
            foreach($jobLevels as $level => $levelName){
                for($dif = 1; $dif <= JobRate::DIFFICULTY_LEVEL_MAX; $dif ++){
                    $id = $type.'-'.$level.'-'.$dif;
                    if(! isset($input[$id])){
                        continue;
                    }
                    # 批量填充
                    $filled = [
                        'id' => $id,
                        'skill_type' => $type,
                        'job_level' => $level,
                        'difficulty_level' => $dif,
                        'rate' => $input[$id],
                    ];
                    # 数据验证
                    $msgs = $this->model->validateForMethod('store', $filled);
                    if (count($msgs)) {
                        foreach($msgs as $msg){
                            Output::json([],"【{$typeName} - {$levelName} - {$dif}】".$msg->getMessage(),412);
                        }
                    }
                    $list[] = $filled;
                }
            }
        }
        $res = $this->model->batchInsertOrUpdate($list,array_keys($filled),['rate']);
        if($res){
            Output::json([],'保存成功');
        }else{
            Output::json([],'保存失败',423);
        }
    }
}
