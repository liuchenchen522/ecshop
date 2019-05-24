<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    //商品列表
    public function goodslist(){
        $data = DB::table('goods')->limit(20)->get();
//        dd($data);
        return view('goods.goodslist',compact('data'));
    }

    //商品详情
    public function goodsdetail($goods_id){
        $data = cache('data'.$goods_id);
        if(!$data){
            echo 123;
            $where = [
                'goods_id'=>$goods_id
            ];
//        dd($goods_id);
            $data = DB::table('goods')->where($where)->first();
            //        dd($data);
            cache(['data'.$goods_id=>$data],60*12);
    }
        $goods_imgs = cache('goods_imgs'.$goods_id);
        if(!$goods_imgs){
            echo 456;
            $goods_imgs = $data->goods_imgs;
            $goods_imgs = rtrim($goods_imgs,'|');
            $goods_imgs = explode('|',$goods_imgs);
            cache(['goods_imgs'.$goods_id=>$goods_imgs],60*12);
            //        dd($goods_imgs);
        }
        $res = DB::table('remark')->orderBy('create_time','desc')->get();
        return view('goods.goodsdetail',compact('data','goods_imgs','res'));
    }

    //商品添加评论
    public function remark(){
        $data = request()->all();
//        dd($data);
        $data['create_time']=time();
        $res = DB::table('remark')->insert($data);
        if($res){
            return ['code'=>1,'font'=>'评论成功'];
        }else{
            return ['code'=>2,'font'=>'评论失败'];
        }
    }

}
