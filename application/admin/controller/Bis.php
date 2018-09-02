<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Bis extends Controller
{
    protected $bis;
    protected function initialize()
    {
        $this->bis = model('bis');
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $bisList = array();
        $ret = $this->bis->bisList($bisList);
        if (!$ret) {
            $this->error('查询商户失败');
        }
        //
        return $this->fetch('', compact('bisList'));
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
    public function dellist($id)
    {
        //
        return $this->fetch();
    }
}
