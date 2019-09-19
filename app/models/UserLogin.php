<?php

class UserLogin extends ModelInit
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("user_login");

        $this->belongsTo('user_id','User','id');
    }

    public $id;
    public $user_id;
    public $token;
    public $access_token;
    public $login_at;
    public $access_at;

    /**
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token ?? Str::makeUniqueStr();

        return $this;
    }

    /**
     * @param $login_at
     * @return $this
     */
    public function setLoginAt($login_at)
    {
        $this->login_at = $login_at ?? time();

        return $this;
    }
    
    /**
     * @param $access_at
     * @return $this
     */
    public function setAccessAt($access_at)
    {
        $this->access_at = time();

        return $this;
    }

    /**
     * 字段
     *
     * @return array
     */
    public static function columns()
    {
        return [
            'id' => ['label' => 'ID', 'attr' => 'int',],
            'user_id' => ['label' => '职员ID', 'attr' => 'int',],
            'token' => ['label' => '登录令牌', 'attr' => 'string',],
            'access_token' => ['label' => 'kpi平台令牌', 'attr' => 'string',],
            'login_at' => ['label' => '登录时间', 'attr' => 'int',],
            'access_at' => ['label' => '最后操作时间', 'attr' => 'int',],
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
            'hide' => [
                'add' => ['id'],
            ],
        ];
    }

    /**
     * 数值描述
     *
     * @return array
     */
    public static function valueDescs()
    {
        return [];
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
            'user_id.integer' => [\Phalcon\Validation\Validator\Regex::class,['pattern'=>'/^\d{1,10}$/','message' => '职员ID 必须是1 ~ 10 位的整数']],
            'token.length' => [\Phalcon\Validation\Validator\Regex::class, ['pattern' => '/^[\S]{16,255}$/', 'message' => '登录令牌 长度 16~255 位']],
            'access_token.length' => [\Phalcon\Validation\Validator\Regex::class, ['pattern' => '/^[\S]{16,255}$/', 'message' => 'kpi平台令牌 长度 16~255 位']],
        ];
    }

    /**
     * 验证规则分组
     *
     * @return array
     */
    public static function rulesGroup()
    {
        return [];
    }

    /**
     *  记录用户登录
     *
     * @param $userId
     * @return $this
     */
    public function record($userId)
    {
        $this->user_id = $userId;
        $this->formatForSave();
        $res = $this->save();

        return $this;
    }
}
