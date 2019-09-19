<?php

class User extends ModelInit
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("user");

        $this->hasMany('id','UserRole','user_id');
        $this->hasManyToMany('id','UserRole','user_id','role_id','Role','id');
        $this->belongsTo('partment_id','Partment','id');
        $this->belongsTo('id','Account','ID');
    }

    public $id;
    public $name;
    public $partment_id;
    public $skill_type;
    public $job;
    public $job_level;
    public $username;
    public $password;
    public $email;
    public $phone;
    public $status;
    public $joined_at;
    public $leaved_at;
    public $created_at;
    public $updated_at;
    public $is_core;

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $info = password_get_info($password);
        if ($password && (0 == $info['algo'] || 'unknown' == $info['algoName'])) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }
        $this->password = $password;

        return $this;
    }

    /**
     * @param $created_at
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at ?? time();
        
        return $this;
    }

    /**
     * @param $joined_at
     * @return $this
     */
    public function setJoinedAt($joined_at)
    {
        if(! $joined_at){
            $joined_at = time();
        }
        if(! is_numeric($joined_at)){
            $joined_at = strtotime($joined_at);
        }
        $this->joined_at = $joined_at ?? time();

        return $this;
    }

    /**
     * @param $leaved_at
     * @return $this
     */
    public function setLeavedAt($leaved_at)
    {
        if($leaved_at && ! is_numeric($leaved_at)){
            $leaved_at = strtotime($leaved_at);
        }
        $this->leaved_at = $leaved_at ?? NULL;

        return $this;
    }

    /**
     * @param $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = time();

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
            'name' => ['label' => '姓名', 'attr' => 'string',],
            'partment_id' => ['label' => '部门ID', 'attr' => 'int',],
            'skill_type' => ['label' => '技术类别', 'attr' => 'int',],
            'job' => ['label' => '职务', 'attr' => 'string',],
            'job_level' => ['label' => '职级', 'attr' => 'int',],
            'username' => ['label' => '用户名', 'attr' => 'string',],
            'password' => ['label' => '密码', 'attr' => 'string',],
            'email' => ['label' => '邮箱', 'attr' => 'string',],
            'phone' => ['label' => '电话', 'attr' => 'string',],
            'status' => ['label' => '状态', 'attr' => 'int',],
            'created_at' => ['label' => '创建时间', 'attr' => 'int',],
            'joined_at' => ['label' => '入职时间', 'attr' => 'int',],
            'leaved_at' => ['label' => '离职时间', 'attr' => 'int',],
            'updated_at' => ['label' => '更新时间', 'attr' => 'int',],
            'is_core' => ['label' => '是否为核心人员', 'attr' => 'int',],
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
                'edit' => ['id','name','password','created_at'],
            ],
        ];
    }

    # 状态
    const STATUS_WORKING = 1;
    const STATUS_LEAVED = 0;
    # 是否为核心人员
    const IS_CORE_NO = 0;
    const IS_CORE_YES = 1;

    /**
     * 数值描述
     *
     * @return array
     */
    public static function valueDescs()
    {
        return [
            'status' => [static::STATUS_WORKING => '在职', static::STATUS_LEAVED => '离职',],
            'is_core' => [static::IS_CORE_NO => '否', static::IS_CORE_YES => '是',],
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
            'id.integer' => [\Phalcon\Validation\Validator\Regex::class, ['pattern' => '/^\d{1,10}$/', 'message' => 'ID 必须是1 ~ 10 位的整数']],
            'name.length' => [\Phalcon\Validation\Validator\Regex::class, ['pattern' => '/^[\S]{2,255}$/', 'message' => '姓名 长度 2~255 位']],
            'partment_id.integer' => [\Phalcon\Validation\Validator\Regex::class, ['pattern' => '/^\d{1,10}$/', 'message' => '部门 必须是1 ~ 10 位的整数']],
            'skill_type.in' => [\Phalcon\Validation\Validator\InclusionIn::class, ['domain' => array_keys(JobRate::getValueDescForField('skill_type')), 'message' => '技术类别 选用指定范围的值', 'allowEmpty' => true]],
            'job.length' => [\Phalcon\Validation\Validator\Regex::class, ['pattern' => '/^[\S ]{2,255}$/', 'message' => '职务 长度 2~255 位']],
            'job_level.in' => [\Phalcon\Validation\Validator\InclusionIn::class, ['domain' => array_keys(JobRate::getValueDescForField('job_level')), 'message' => '职级 选用指定范围的值', 'allowEmpty' => true]],
            'username.alnum' => [\Phalcon\Validation\Validator\Alnum::class, ['message' => '用户名 只能是字符串或数字组合','allowEmpty' => true]],
            'username.length' => [\Phalcon\Validation\Validator\Regex::class, ['pattern' => '/^\w{3,255}$/', 'message' => '用户名 长度应介于3 ~ 255 位','allowEmpty' => true]],
            'username.unique' => [\Phalcon\Validation\Validator\Uniqueness::class,['model'=>$this,'message' => '用户名 已存在','allowEmpty' => true]],
            'password.length' => [\Phalcon\Validation\Validator\Regex::class, ['pattern' => '/^\S{6,255}$/', 'message' => '密码 长度 6~255 位','allowEmpty' => true]],
            'email.email' => [\Phalcon\Validation\Validator\Email::class, ['message' => '邮箱 格式错误']],
            'phone.length' => [\Phalcon\Validation\Validator\Regex::class, ['pattern' => '/^1[3-9][0-9]{9}$/', 'message' => '电话 格式错误', 'allowEmpty' => true]],
            'status.in' => [\Phalcon\Validation\Validator\InclusionIn::class, ['domain' => array_keys(static::getValueDescForField('status')), 'message' => '状态 选用指定范围的值']],
            'joined_at.date' => [\Phalcon\Validation\Validator\Date::class, ['format' => 'Y-m-d', 'message' => '入职时间 格式错误']],
            'leaved_at.date' => [\Phalcon\Validation\Validator\Date::class, ['format' => 'Y-m-d', 'message' => '离职时间 格式错误', 'allowEmpty' => true]],
            'is_core.in' => [\Phalcon\Validation\Validator\InclusionIn::class, ['domain' => array_keys(static::getValueDescForField('is_core')), 'message' => '状态 选用指定范围的值']],
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
            'edit' => ['partment_id.integer','skill_type.in','job.length','job_level.in','username.alnum','username.length','username.unique','password.length','email.email','phone.length','status.in','joined_at.date','leaved_at.date','is_core.in'],
            'login' => ['username.alnum','username.length','password.length'],
        ];
    }

    /**
     * 处理登录
     *
     * @param $input
     * @return array|string
     */
    public function handleLogin($input)
    {
        # 数据验证
        $msgs = $this->validateForMethod('login', $input);
        if (count($msgs)) {
            foreach($msgs as $msg){
                return $msg->getMessage();
            }
        }
        # 获取账号
        $user = static::findFirst(['username = :username:','bind' => ['username' => $input['username']]]);
        if( !$user){
            return '账号不存在';
        }
        # 比对密码
        $vali = password_verify($input['password'],$user->password);
        if( ! $vali){
            return '密码错误';
        }
        # 检查账号状态
        if(self::STATUS_WORKING != $user->status){
            return '账号已不能正常使用';
        }
        # 生成登录记录
        $userLogin = UserLogin::instance()->record($user->id);

        return [
            'user' => $user,
            'login' => $userLogin,
        ];
    }
}
