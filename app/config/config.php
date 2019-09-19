<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

require_once __DIR__.'/constants.php';

# 邮件配置
$file = APP_PATH.'/json/smtp.json';
$originSmtp = [
    'host' => [
        'name' => 'host',
        'label' => 'SMTP服务器',
        'attr' => 'string',
        'value' => 'smtp.qq.com',
        'select' => null,
    ],
    'auth' => [
        'name' => 'auth',
        'label' => '是否认证',
        'attr' => 'bool',
        'value' => true,
        'select' => [1 => '是', 0 => '否'],
    ],
    'secure' => [
        'name' => 'secure',
        'label' => '安全协议',
        'attr' => 'string',
        'value' => 'ssl',
        'select' => ['ssl','tls'],
    ],
    'port' => [
        'name' => 'port',
        'label' => '服务端口',
        'attr' => 'int',
        'value' => 587,
        'select' => null,
    ],
    'username' => [
        'name' => 'username',
        'label' => '用户名',
        'attr' => 'string',
        'value' => '',
        'select' => null,
    ],
    'password' => [
        'name' => 'password',
        'label' => '密码',
        'attr' => 'string',
        'value' => '',
        'select' => null,
    ],
    'name' => [
        'name' => 'name',
        'label' => '默认发件人',
        'attr' => 'string',
        'value' => '',
        'select' => null,
    ],
    'email' => [
        'name' => 'email',
        'label' => '默认发件邮箱',
        'attr' => 'string',
        'value' => '',
        'select' => null,
    ],
];
if(file_exists($file) && $content = file_get_contents($file)){
    $originSmtp = json_decode($content,true);
}else{
    file_put_contents($file,json_encode($originSmtp,JSON_OPTION));
}
$smtp = array_column($originSmtp,'value','name');

return new \Phalcon\Config([
    'database' => [
        'adapter'     => 'Mysql',
//        'host'        => '127.0.0.1:3307',
//        'username'    => 'appraisal',
//        'password'    => 'db_admin_yz',
        'host'        => '127.0.0.1',
        'username'    => 'root',
        'password'    => '168168',
        'dbname'      => 'task_v2',
        'charset'     => 'utf8',
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',

        // This allows the baseUri to be understand project paths that are not in the root directory
        // of the webpspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
//        'baseUri'        => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
        'baseUri'        => '/',
    ],
    'smtp' => $smtp,
]);
