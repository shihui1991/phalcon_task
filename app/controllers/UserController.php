<?php

class UserController extends ControllerAuth
{
    protected $modelClass = User::class;

    /**
     * 列表
     */
    public function indexAction()
    {
        $this->index();
    }

    /**
     * 信息
     */
    public function infoAction()
    {
        $this->info();
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
        # 删除职员角色
        UserRole::find('user_id in ('.$ids.')')->delete();
        if($res){
            Output::json();
        }else{
            Output::json([],'操作失败',423);
        }
    }

    /**
     * 获取或更新职员角色
     */
    public function roleAction()
    {
        $id = $this->get('user_id','int');
        if(empty($id)){
            Output::json([],'请选择角色',412);
        }
        # 职员的角色ID
        if($this->request->isGet()){
            $userRoles = UserRole::find('user_id = '.$id);
            $roleIds = [];
            if($userRoles) foreach($userRoles as $userRole){
                $roleIds[] = $userRole->role_id;
            }
            Output::json([
                'role_ids' => $roleIds,
                'user_id' => $id,
            ],'');
        }
        # 保存职员的角色ID
        else{
            # 清空之前的
            UserRole::find('user_id = '.$id)->delete();
            $roleIds = $this->get('role_ids',null,[]);
            if(empty($roleIds)){
                Output::json();
            }
            # 整理数据
            $list = [];
            foreach($roleIds as $roleId){
                $list[] = [
                    'user_id' => $id,
                    'role_id' => $roleId,
                ];
            }
            $res = UserRole::instance()->batchInsertOrUpdate($list);
            if($res){
                Output::json();
            }else{
                Output::json([],'操作失败',423);
            }
        }
    }
}
