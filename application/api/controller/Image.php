<?php
namespace app\api\controller;

use think\Controller;
use think\Request;

class Image extends Controller
{
    private $code = 100;
    private $msg = '';
    public function uploadImage(Request $request) {
        $file = $request->file('file');
        $info = $file->move('upload');
        if($info && $info->getPathname()) {
            $data = [
                'img_path' => '/'.$info->getPathname()
            ];
            return $this->ajaxReturn($data);
        }else {
            $this->code = 102;
            $this->msg = '图片上传失败';
            return $this->ajaxReturn();
        }
    }

    public function ajaxReturn($data = []) {
        return json_encode([
            'code' => $this->code,
            'data' => $data,
            'msg' => $this->msg
        ]);
    }
}