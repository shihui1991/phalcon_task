<?php

class Output
{
    /**
     * @param array $data
     * @param string $msg
     * @param int $code
     */
    public static function json( $data = [], $msg = '操作成功', $code = 20000)
    {
        $resp = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
        echo json_encode($resp,JSON_OPTION);
        exit;
    }
}