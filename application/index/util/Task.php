<?php
/**
 * Created by PhpStorm.
 * User: luoyaoxing
 * Date: 18-8-29
 * Time: 下午10:03
 */

namespace app\index\util;


class Task
{
    public function doTask() {
        return json_encode([
            'name' => 'daniel',
            'age' => 22,
            'sex' => 1
        ]);
    }
}