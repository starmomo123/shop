<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Deal extends Controller
{
    private $user;
    private $deal;
    private $category;
    private $bis;
    private $bisLocation;
    private $bisAccount;
    protected function initialize()
    {
        $this->user = model('user');
        $this->deal = model('deal');
        $this->category = model('category');
        $this->bis = model('bis');
        $this->bisLocation = model('BisLocation');
        $this->bisAccount = model('bis_account');
        parent::initialize(); // TODO: Change the autogenerated stub
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function detail($id = 0)
    {
        $title = '详情页';
        $type = 0;
        $timeInfo = '';
        $category = $this->getCategory();
        $deal = $this->deal->get($id);
        $this->getDealTimeInfo($deal['start_time'], $deal['end_time'], $type, $timeInfo);
        //
        return $this->fetch('',
            compact('deal', 'title', 'category', 'type', 'timeInfo')
        );
    }

    public function buy(Request $request) {
        $deal_id = input('get.deal_id');
        $price = input('get.price');
        $count = input('count');
        $totalPrice = $price*$count;
        $shouldPrice = $totalPrice;
        $uid = session('uid');
        $user = $this->user->get($uid);
        $deal = $this->deal->get($deal_id);
        if (empty($user)) {
            $this->error('请先登录', url('index/login/login'));
        }
        $title = '支付页';
        return $this->fetch('',
            compact('title', 'user', 'deal', 'price', 'count', 'totalPrice', 'shouldPrice')
        );
    }

    protected function getCategory($categoty_id = 0) {
        $category = array();
        $this->category->getNormalFirstCategory($category, $categoty_id);
        foreach ($category as &$item) {
            $item['sub_category'] = $this->getCategory($item['id']);
        }
        return $category;
    }

    protected function getDealTimeInfo($start, $end, &$type, &$timeInfo) {
        $start = strtotime($start);
        $end = strtotime($end);
        $current = time();
        if ($current >= $start && $current <= $end) {
            $type = 1;
            $timeInfo = '团购开始啦，赶紧抢购哦～～';
        }elseif ($current < $start) {
            $type = 2;
            $timeInfo = $this->calTime($start, $current);
        }elseif ($current > $end) {
            $type =3;
            $timeInfo= '团购已结束';
        }
    }

    protected function calTime($start, $current) {
        $time = $start-$current;
        $day = floor($time/86400);
        $h = floor(($time-$day*86400)/3600);
        $m = floor(($time-$day*86400-$h*3600)/60);
        $s = ($time-$day*86400-$h*3600)%60;
        $timeInfo = '';
        if ($day > 0) {
            $timeInfo .= $day.'天';
        }
        if ($h < 10) {
            $timeInfo .= '0'.$h.'小时';
        }else {
            $timeInfo .= $h.'小时';
        }
        if ($m < 10) {
            $timeInfo .= '0'.$m.'分钟';
        }else {
            $timeInfo .= $m.'分钟';
        }
        if ($s < 10) {
            $timeInfo .= '0'.$s.'秒';
        }else {
            $timeInfo .= $s.'秒';
        }
        return $timeInfo;
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
