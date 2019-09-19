<?php
/*
 * 访问限制控制器 基类
 */
class ControllerAuth extends ControllerInit
{
    protected $requestMenu;
    protected $loginInfo;
    protected $loginUser;

    public function initialize()
    {
        parent::initialize();

        $this->checkLogin();
        $this->checkAuth();
    }

    /**
     * 检查登录状态
     */
    protected function checkLogin()
    {
        if(empty($_COOKIE['login_info_user_id']) || empty($_COOKIE['login_info_user_token'])){
            Output::json([],'请先登录',40300);
        }
        $userId = $_COOKIE['login_info_user_id'];
        $token = $_COOKIE['login_info_user_token'];
        # 获取最近登录信息
        $login = UserLogin::findFirst([
            'user_id = :userId:',
            'bind' => ['userId' => $userId],
            'order' => 'login_at DESC',
            ]);
        if(!$login){
            Output::json([],'请先登录',40300);
        }
        if($token != $login->token){
            Output::json([],'登录令牌已失效，请重新登录',40300);
        }
        $time = time();
        if($time > ($login->access_at + 7200)){
            Output::json([],'长时间未操作，登录令牌已失效',40300);
        }
        $login->access_at = $time;
        $login->save();

        $this->loginInfo = $login;
    }

    /**
     * 检查是否权限操作
     *
     * @return bool
     */
    protected function checkAuth()
    {
        # 获取登录用户
        $user = User::findFirst($this->loginInfo->user_id);
        $this->loginUser = [
            'user' => $user,
            'isRoot' => false,
            'roleIds' => [],
        ];
        # 获取请求的菜单信息
        $this->requestMenu = Menu::findFirst(['uri = :uri:','bind' => ['uri' => $this->requestURI]]);
        # 菜单访问控制
        if(! $this->requestMenu){
//            Output::json([],'路径暂未配置',423);
            return true;
        }
        if(Menu::IS_CTRL_NO == $this->requestMenu->is_ctrl){
            return true;
        }
        if(Menu::STATUS_OFF == $this->requestMenu->status){
            Output::json([],'路径禁止访问',423);
        }
        # 角色权限
        $roles = $user->role;
        if(empty($roles)){
            Output::json([],'无访问权限',423);
        }
        $roleIds = [];
        foreach($roles as $role){
            if(Role::STATUS_OFF == $role->status) continue;
            if(Role::IS_ROOT_YES == $role->is_root){
                $this->loginUser['isRoot'] = true;
                return true;
            }
            $roleIds[] = $role->id;
        }
        if(empty($roleIds)){
            Output::json([],'无访问权限2',423);
        }
        $this->loginUser['roleIds'] = $roleIds;
        # 可访问菜单
        $roleMenus = RoleMenu::find('role_id IN ('.implode(',',$roleIds).')');
        if(empty($roleMenus)){
            Output::json([],'无访问权限3',423);
        }
        foreach($roleMenus as $roleMenu){
            if($this->requestMenu->id == $roleMenu->menu_id){
                return true;
            }
        }
        Output::json([],'无访问权限4',423);
    }
}
