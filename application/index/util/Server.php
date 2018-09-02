<?php
/**
 * Created by PhpStorm.
 * User: luoyaoxing
 * Date: 18-8-29
 * Time: 下午9:38
 */

namespace app\index\util;

use think\Exception;

class Server
{
    private $host='127.0.0.1';
    private $port=8089;
    private $errcode=0;
    private $errmsg='';
    private $cdn='';
    private static $instance=null;
    private $queue=[];
    private $socket;
    private $timeout=300;
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

    protected function listen() {
        $this->socket = stream_socket_server($this->cdn,$errCode, $errMsg);
        if(!$this->socket) {
            $this->errcode=$errCode;
            $this->errmsg=$errMsg;
            throw new Exception($this->errmsg, $this->errcode);
        }
    }

    public function handleData() {
        $this->listen();
        while ($conn = stream_socket_accept($this->socket, $this->timeout)) {
            while (!feof($conn)) {
                array_push($this->queue, fread($conn,1024));
                $task = array_pop($this->queue);
                $task = json_decode($task, true);
                echo $task['class']."\n";
                echo $task['method'];
                $schdule = new $task['class']();
                $ret = $schdule->doTask();
                fwrite($conn, $ret);
            }
        }
    }
}