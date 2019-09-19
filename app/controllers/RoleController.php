<?php

class RoleController extends ControllerAuth
{
    protected $modelClass = Role::class;

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
        # 调整下级的所属级
        $this->model->find('parent_id in ('.$ids.')')->update(['parent_id' => 0]);
        # 删除授权菜单
        RoleMenu::find('role_id in ('.$ids.')')->delete();
        if($res){
            Output::json();
        }else{
            Output::json([],'操作失败',423);
        }
    }

    /**
     * 获取或更新授权菜单
     */
    public function menuAction()
    {
        $id = $this->get('role_id','int');
        if(empty($id)){
            Output::json([],'请选择角色',412);
        }
        # 角色授权的菜单ID
        if($this->request->isGet()){
            $roleMenus = RoleMenu::find('role_id = '.$id);
            $menuIds = [];
            if($roleMenus) foreach($roleMenus as $roleMenu){
                $menuIds[] = $roleMenu->menu_id;
            }
            Output::json([
                'menu_ids' => $menuIds,
                'role_id' => $id,
            ],'');
        }
        # 保存角色授权的菜单ID
        else{
            # 清空之前的
            RoleMenu::find('role_id = '.$id)->delete();
            $menuIds = $this->get('menu_ids',null,[]);
            if(empty($menuIds)){
                Output::json();
            }
            # 整理数据
            $list = [];
            foreach($menuIds as $menuId){
                $list[] = [
                    'role_id' => $id,
                    'menu_id' => $menuId,
                ];
            }
            $res = RoleMenu::instance()->batchInsertOrUpdate($list);
            if($res){
                Output::json();
            }else{
                Output::json([],'操作失败',423);
            }
        }
    }
}
