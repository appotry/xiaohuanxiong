<?php


namespace app\model;


use think\db\Where;
use think\Model;

class Banner extends Model
{
    public function book()
    {
        return $this->hasOne('book', 'id', 'book_id');
    }

    public function setTitleAttr($value)
    {
        return trim($value);
    }

    function getBanners($order, $where,$num)
    {
        $img_domain = config('site.img_domain');
        if ($num == 0) {
            $data = Banner::with('book')
                ->order($order)->where($where)->select();
        } else {
            if (strpos($num, ',') !== false) {
                $arr = explode(',',$num);
                $data = Banner::where($where)
                    ->limit($arr[0],$arr[1])->order($order)->select();
            } else {
                $data = Banner::with('book')->order($order)->where($where)->limit($num)->select();
            }
        }

        $banners = array();
        foreach ($data as $banner) {
            if (substr($banner['pic_name'], 0, strlen('http')) != 'http') {
                $banner['pic_name'] = $img_domain .  $banner['pic_name'];
            }
            array_push($banners, $banner);
        }
        return $banners;
    }
}