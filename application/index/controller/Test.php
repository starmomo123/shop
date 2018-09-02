<?php

namespace app\index\controller;

use app\index\util\Client;
use app\index\util\Server;
use think\Controller;
use think\Request;

class Test extends Controller
{
    public function server() {
       $server = Server::getInstance();
       $server->handleData();
    }

    public function client() {
        $client = Client::getInstance();
        $data = [
            'class' => "app\index\util\Task",
            'method' => 'doTask'
        ];
        $ret = $client->sendData($data);
        dump($ret);exit;
    }
}
