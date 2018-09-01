<?php
/**
 * Created by PhpStorm.
 * User: luoyaoxing
 * Date: 18-8-29
 * Time: 下午9:39
 */

namespace app\index\util;


use think\Exception;

class Client
{
    private $host='127.0.0.1';
    private $port=8089;
    private $errcode=0;
    private $errmsg='';
    private $cdn='';
    private static $instance=null;
    private $socket;
    protected function __construct($config=[]) {
        //先取默认的值
        $this->cdn="tcp://{$this->host}:{$this->port}";
    }

    public static function getInstance($config=[]) {
        if(isset(self::$instance)) {
            return self::$instance;
        }else {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    protected function openConnect() {
        $this->socket = stream_socket_client($this->cdn,$errno, $errstr);
        $this->errcode=$errno;
        $this->errmsg=$errstr;
    }

    public function sendData($data) {
        //先不考虑异步的情况
        $this->openConnect();
        if(!$this->socket) {
            return [
                'code' => $this->errcode,
                'msg' => $this->errmsg
            ];
        }
        $data = json_encode($data);
        if(fwrite($this->socket, $data) != strlen($data)) {
            throw new Exception($this->errmsg, $this->errcode);
        }
        return $this->revData();
    }

    public function revData() {
        $ret = fread($this->socket, 1024);
        fclose($this->socket);
        return json_decode($ret, true);
    }
}