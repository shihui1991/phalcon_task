<?php
/*
 * 字符串处理类
 * */

//namespace app\library;


class Str
{
    /**
     * 下划线转驼峰
     *
     * @param $value
     * @return mixed|string
     */
    public static function camel($value)
    {
        $value = ucwords(str_replace('_',' ',$value));
        $value = str_replace(' ','',$value);
        $value = lcfirst($value);

        return $value;
    }

    /**
     * 驼峰转下划线
     *
     * @param $value
     * @return string|string[]|null
     */
    public static function snake($value)
    {
        if (! ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));
            $value = preg_replace('/(.)(?=[A-Z])/u', '$1'.'_', $value);
            $value = mb_strtolower($value,'UTF-8');
        }

        return $value;
    }

    /**
     * 截取URI
     *
     * @param $uri
     * @return bool|string
     */
    public static function cutURI($uri)
    {
        $index = strpos($uri,'?');
        if(false !== $index){
            $uri = substr($uri,0,$index);
        }
        $arr = explode('/',$uri);
        $arr = array_reverse($arr);
        foreach($arr as $i => $str){
            if($str && 'index' != $str){
                break;
            }
            unset($arr[$i]);
        }
        $arr = array_filter(array_reverse($arr));
        $uri = '/'.implode('/',$arr);

        return $uri;
    }

    /**
     * 截取字符串
     *
     * @param $str
     * @param int $len
     * @return string
     */
    public static function cutStr($str, $len = 3)
    {
        return mb_strlen($str) > $len ? mb_substr($str,0,$len).'...' : $str;
    }

    /**
     * 生成时间随机字符串
     *
     * @param bool $upper
     * @return string
     */
    public static function makeUniqueStr($upper = false){
        $guidStr = md5(uniqid(mt_rand(), true));
        if($upper){
            $guidStr = strtoupper($guidStr);
        }
        return $guidStr;
    }
}