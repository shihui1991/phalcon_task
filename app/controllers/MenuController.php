<?php

class MenuController extends ControllerAuth
{
    protected $modelClass = Menu::class;

    /**
     * 列表
     */
    public function indexAction()
    {
        $this->index();
    }

    /**
     * 保存
     */
    public function storeAction()
    {
        $this->store();
    }

    /**
     * 通过ID删除
     */
    public function delAction()
    {
        $ids = $this->get('ids');
        if(empty($ids)){
            Output::json([],'请至少选择一项',412);
        }
        if(is_array($ids)){
            $ids = implode(',',$ids);
        }
        $res = $this->model->find('id in ('.$ids.')')->delete();
        $this->model->find('parent_id in ('.$ids.')')->update(['parent_id' => 0]);
        if($res){
            Output::json();
        }else{
            Output::json([],'操作失败',423);
        }
    }
}
