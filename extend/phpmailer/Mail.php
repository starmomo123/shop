<?php
/**
 * Created by PhpStorm.
 * User: luoyaoxing
 * Date: 18-8-26
 * Time: 下午2:00
 */
namespace phpmailer;
require 'phpmailer.php';
require 'smtp.php';
class Mail
{
    public static function send($to, $title, $content) {
        date_default_timezone_set('PRC');//set time
        try{
            $mail = new \PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = config('mail.mail_debug');
            $mail->Debugoutput = config('mail.mail_debugoutput');
            $mail->Host = config('mail.mail_host');
            $mail->Port = config('mail.mail_port');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.mail_username');
            $mail->Password = config('mail.mail_password');
            $mail->Timeout = config('mail.mail_timeout');
            $mail->setFrom(config('mail.mail_username'), config('mail.mail_name'));
            $mail->addAddress($to, '陌陌');
            $mail->Subject = $title;
            $mail->msgHTML($content);
            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        }catch (\phpmailer\phpmailerException $e) {
            return false;
        }
    }
}