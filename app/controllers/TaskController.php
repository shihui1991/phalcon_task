<?php

class TaskController extends ControllerAuth
{
    protected $modelClass = Task::class;

    /**
     * 我的今日任务
     */
    public function todayAction()
    {
        $today = date('Y-m-d');
        $task = $this->model->findFirst("date = '{$today}' AND user_id = {$this->loginInfo->user_id}");
        Output::json($task,'');
    }

    /**
     * 我的每日任务
     */
    public function mineAction()
    {
        $query = $this->filterQuery($this->modelClass,'t')
            ->columns([
                't.id',
                't.date',
                't.task',
                't.next_task',
                't.issues',
                't.mark',
                't.created_at',
                'COUNT(tr.id) AS reply',
            ])
            ->leftJoin('TaskReply','tr.task_id = t.id AND tr.to_user_id = '.$this->loginInfo->user_id,'tr')
            ->andWhere("t.user_id = {$this->loginInfo->user_id}")
            ->groupBy('t.id')
            ->orderBy('t.date DESC');
       $this->respQueryList($query);
    }

    /**
     * 保存
     */
    public function storeAction()
    {
        $input = $this->get('input',null,[]);
        if(empty($input)){
            Output::json([],'请填写日报内容',412);
        }
        $input['user_id'] = $this->loginInfo->user_id;
        # 批量填充
        $data = $this->model->batchFill($input, 'store');
        # 数据验证
        $msgs = $this->model->validateForMethod('store', $data);
        if (count($msgs)) {
            foreach ($msgs as $msg){
                Output::json([],$msg->getMessage(),412);
            }
        }
        # 查询是否已上报
        $row = $this->model->findFirst("date = '{$data['date']}' AND user_id = {$this->loginInfo->user_id}");
        # 判断修改
        if($row){
            # 非今日上传不能修改
            if(date('Y-m-d') != date('Y-m-d',$row->created_at)){
                Output::json([],'非今日填报的任务不能修改',405);
            }
            # 已有人标记阅读不能修改
            $status = TaskReader::instance()->checkTaskReaderStatus($row->id);
            if(TaskReader::STATUS_READ == $status){
                Output::json([],'已阅读的任务不能修改',405);
            }
            $isNew = 0;
            $row->batchFill($input, 'store');
            $res = $row->save();
        }
        # 添加
        else{
            $isNew = 1;
            $res = $this->model->save();
            $row = $this->model;
        }
        if($res){
            Output::json([
                'row' => $row,
                'isNew' => $isNew,
            ],'保存成功');
        }else{
            Output::json([],'保存失败',412);
        }
    }

    /**
     * 获取通用列表查询器
     *
     * @return \Phalcon\Mvc\Model\Query\Builder
     */
    protected function getListQuery()
    {
        return $this->modelsManager->createBuilder()
            ->columns([
                't.id',
                't.date',
                't.user_id',
                't.task',
                't.next_task',
                't.issues',
                't.mark',
                't.created_at',
                't.updated_at',
                'u.name as user_name',
            ])
            ->from(['t' => 'Task'])
            ->leftJoin('User','u.id = t.user_id','u')
            ->orderBy('t.date DESC');
    }

    /**
     * 信息
     */
    public function infoAction()
    {
        $id = $this->request->get('id','int',0);
        if($id < 1){
            Output::json([],'请选择其中一项',412);
        }
        $list = $this->getListQuery()
            ->where('t.id = '.$id)
            ->getQuery()
            ->execute();
        if( ! $list){
            Output::json([],'选择的数据不存在',410);
        }

        Output::json($list[0],'');
    }

    /**
     * 列表
     */
    public function indexAction()
    {
        $this->index();
    }


}
