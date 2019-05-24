<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
class IndexController extends Controller
{
    //首页
    public function index(){
        $data = cache('data');
        if(!$data){
            echo "Memcache";
            $data = DB::table('goods')->where('is_up',1)->get();
//        dd($data);
            cache(['data'=>$data],5);
        }

        $cate = cache('cate');
        if(!$cate){
            echo "顶级分类";
            $cate=DB::table('category')->where('pid',0)->get();
            cache(['cate'=>$cate],5);
        }
        $where=[
            'goods_id'=>80
        ];
        $goodsImgs = DB::table('goods')->where($where)->first();
        $goods_imgs = $goodsImgs->goods_imgs;
        $goods_imgs = rtrim($goods_imgs,'|');
        $goods_imgs = explode('|',$goods_imgs);

        $session = request()->session()->get('userInfo');
        return view('index.index',compact('data','session','cate','goods_imgs','goodsImgs'));
    }
}
