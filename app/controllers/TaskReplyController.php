<?php

class TaskReplyController extends ControllerAuth
{
    protected $modelClass = TaskReply::class;

    /**
     * 通用列表查询器
     *
     * @return \Phalcon\Mvc\Model\Query\Builder
     */
    protected function getListQuery()
    {
        return $this->filterQuery($this->modelClass,'tr')
            ->columns([
                'tr.id',
                'tr.parent_id',
                'tr.task_id',
                'tr.user_id',
                'tr.to_user_id',
                'tr.content',
                'tr.status',
                'tr.created_at',
                'u.name as user_name',
            ])
            ->leftJoin('User','u.id = tr.user_id','u')
            ->orderBy('tr.created_at DESC');
    }

    /**
     * 获取我的消息列表
     */
    public function mineAction()
    {
        $query = $this->getListQuery();
        $columns = $query->getColumns();
        $addColumns = ['t.date', 't.task', 't.issues','tu.name as task_user'];
        $columns = array_merge($columns,$addColumns);
        $query->columns($columns)
            ->leftJoin('Task','t.id = tr.task_id','t')
            ->leftJoin('User','tu.id = t.user_id','tu')
            ->andWhere("tr.to_user_id = {$this->loginInfo->user_id}");

        $this->respQueryList($query);
    }

    /**
     * 标记已读
     */
    public function readAction()
    {
        $ids = $this->get('ids');
        if(is_array($ids)){
            $ids = implode(',',$ids);
        }
        $res = TaskReply::find("id in ({$ids}) AND to_user_id = {$this->loginInfo->user_id}")
            ->update(['status' => TaskReply::STATUS_READ, 'updated_at' => time()]);
        if($res){
            Output::json();
        }else{
            Output::json([],'操作失败',423);
        }
    }

    /**
     * 日报的消息
     */
    public function taskAction()
    {
        $taskId = $this->get('task_id');
        $list = $this->getListQuery()
            ->andWhere('tr.task_id = '.$taskId)
            ->orderBy('tr.parent_id ASC,tr.created_at ASC')
            ->getQuery()
            ->execute();
        # 全部标记已读
        $res = TaskReply::find("task_id = {$taskId} AND to_user_id = {$this->loginInfo->user_id}")
            ->update(['status' => TaskReply::STATUS_READ, 'updated_at' => time()]);

        $treeList = Arr::makeTreeOrderList($list->toArray());

        Output::json(['list' => $treeList],'');
    }

    /**
     * 发送消息
     */
    public function storeAction()
    {
        $input = $this->get('input');
        $input['user_id'] = $this->loginInfo->user_id;
        $input['status'] = TaskReply::STATUS_UNREAD;
        $this->store(null,$input);
    }

    /**
     * 删除
     */
    public function delAction()
    {
        $this->del();
    }
}
