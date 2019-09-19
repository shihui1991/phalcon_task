<?php


class Other
{

    /**
     * 发送邮件
     *
     * @param $config
     * @param $toArr
     * @param $title
     * @param $body
     * @param $from
     * @param string $altBody
     * @return bool
     */
    public static function sendEmail($config, $toArr, $title, $body, $altBody = '', $from = [])
    {
        require_once APP_PATH . '/plugins/phpmailer/PHPMailerAutoload.php';

        $mail = new PHPMailer(true);

        try {
            # 配置
            $mail->CharSet ="UTF-8";
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = $config['host'];
            $mail->SMTPAuth   = $config['auth'];
            $mail->Username   = $config['username'];
            $mail->Password   = $config['password'];
            $mail->SMTPSecure = $config['secure'];
            $mail->Port       = $config['port'];

            # 发件人
            if( ! empty($from)){
                $mail->setFrom($from['email'], $from['name']);
            }else{
                $mail->setFrom($config['email'], $config['name']);
            }
            # 收件人
            foreach($toArr as $to){
				echo $to['email'];
                $mail->addAddress($to['email'], $to['name']);
            }
            # 内容
            $mail->isHTML(true);
            $mail->Subject = $title;
            $mail->Body    = $body;
            $mail->AltBody = $altBody;

            $mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 文件输出头
     */
    public static function outputHeaderForFile($name, $size = 0)
    {
        // Redirect output to a client’s web browser (Excel5)
        header ( "Content-Type: application/octet-stream" );
        header ( "Content-Transfer-Encoding: binary" );
        Header ( "Accept-Ranges: bytes ");
        header ('Content-Disposition: attachment;filename="'.$name.'"');
        if($size > 0){
            header ( 'Content-Length: ' . $size);
        }

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        header ('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header ('Cache-Control: max-age=1');
        header ( "Cache-Control: must-revalidate, post-check=0, pre-check=0 ");
    }

    /**
     * 输出任务日期
     */
    public static function getTaskDate($date)
    {
        $weeks = [
            1 => '一',
            2 => '二',
            3 => '三',
            4 => '四',
            5 => '五',
            6 => '六',
            7 => '日',
        ];
        $week = $weeks[date('N',strtotime($date))];

        return $date.'('.$week.')';
    }
}