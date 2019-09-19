<?php

class LoginController extends ControllerInit
{

    /**
     * 登录
     */
    public function indexAction()
    {
        $input = $this->get('input',null,[]);
        $res = User::instance()->handleLogin($input);
        if(is_array($res)){
            Output::json($res,'登录成功');
        }else{
            Output::json([],$res,404);
        }
    }

    /**
     * 退出
     */
    public function logoutAction()
    {
        Output::json();
    }
}
