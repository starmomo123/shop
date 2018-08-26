<?php
/**
 * Created by PhpStorm.
 * User: luoyaoxing
 * Date: 18-8-26
 * Time: 下午12:03
 */

class Map
{
    /**
     * 根据地理位置获取经纬度
     * 地理位置如:北京市海淀区上地十街10号
     * @param $address
     */
    public static function getLngLat($address) {
        if(empty($address)) {
            return ;
        }
        $data = [
            'address' => $address,
            'ak' => config('map.map_ak'),
            'output' => 'json'
        ];
        $url = config('map.map_host').config('map.map_geouri').'?'.http_build_query($data);
        $ret = doCurl($url);
        $ret = json_decode($ret, true);
        return $ret['result']['location'];
    }

    /**
     * 根据地理位置或经纬度获取静态图片
     * 地理位置如:北京市海淀区上地十街10号
     * 经纬度如:123.213,231.1232
     * @param $center
     */
    public static function getStaticImage($center) {
        if(empty($center)) {
            return ;
        }
        $data = [
            'center' => $center,
            'ak' => config('map.map_ak'),
            'width' => config('map.map_width'),
            'height' => config('map.map_height'),
            'zoom' => config('map.map_zoom')
        ];
        $url = config('map.map_host').config('map.map_staticimageuri').'?'.http_build_query($data);
        $ret = doCurl($url);
        return $ret;
    }
}