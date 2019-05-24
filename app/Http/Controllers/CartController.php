<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /** 加入购物车 */
    public function cartAdd(){
        $goods_id = request()->goods_id;
        $buy_number = request()->buy_number;
//        dd($goods_id);
//        dd($buy_number);
        $goodsWhere = [
            'goods_id' => $goods_id,
            'is_up' => 1
        ];
        $goodsInfo = DB::table('goods')->where($goodsWhere)->first();
//        dd($goodsInfo);
        if(empty($goods_id)){
            return ['code'=>2,'res'=>'请选择一个商品'];
        }else if (empty($goodsInfo)){
            return ['code'=>2,'res'=>'您选择的商品已下架'];
        }
        if(empty($buy_number)) {
            return ['code'=>2,'res'=>'请选择要购买的商品数量'];
        }
        $userInfo = request()->session()->get('userInfo');
        $goodsInfo = DB::table('user')->where('user_email',$userInfo['user_email'])->first();
//        dd($goodsInfo);
        $user_id = $goodsInfo->user_id;
//        dd($user_id);
        $info = [
            'goods_id' => $goods_id,
            'buy_number' => $buy_number,
            'user_id'=>$user_id,
            'create_time' => time()
        ];
        $res = DB::table('cart')->insert($info);
        if($res){
            return ['code' => 1, 'res' => '加入购物车成功'];
        } else {
            return ['code' => 0, 'res' => '加入购物车失败'];
        }

    }

    //购物车列表
    public function cartlist(){
        $user = request()->session()->get('userInfo');
        $goodsInfo = DB::table('user')->where('user_email',$user['user_email'])->first();
        $user_id = $goodsInfo->user_id;
        $res=DB::table('cart')
            ->join('goods','goods.goods_id','=','cart.goods_id')
            ->where(['user_id'=>$user_id,'cart_status'=>1])
            ->get();
//        dd($res);
        return view('cart.cartlist',compact('res'));
    }

    //获取总价
    public function counTotal(){
//        echo 123;
        $goods_id = request()->goods_id;
        $goods_id=explode(',',$goods_id);
//        dd($goods_id);
        $user = request()->session()->get('userInfo');
        $goodsInfo = DB::table('user')->where('user_email',$user['user_email'])->first();
        $user_id = $goodsInfo->user_id;
//        dd($user_id);
        //从数据库中获取总价
        $goodsWhere=[
            [ 'is_up','=',1],
            ['user_id','=',$user_id],
        ];
        $goodsInfo=DB::table('cart')
            ->select('self_price','buy_number')
            ->join('goods', 'cart.goods_id', '=', 'goods.goods_id')
            ->where($goodsWhere)
            ->whereIn('cart.goods_id',$goods_id)
            ->get();
//        dd($goodsInfo);
        $count = 0;
        foreach ($goodsInfo as $k => $v) {
            $count+=$v->buy_number*$v->self_price;
        }
        echo $count;
    }

    //更改数据库中数据
    public function changeBuyNumber(){
        $goods_id = request()->goods_id;
        $buy_number = request()->buy_number;
        if (empty($goods_id)) {
            fail('请至少选择一件商品');
        }
        if (empty($buy_number)) {
            fail('购买数量不能为空');
        }
        $changeBuyNumberDb = $this->changeBuyNumberDb($goods_id,$buy_number);
    }
    //更改数据库中数据方法
    public function changeBuyNumberDb($goods_id,$buy_number){
        $session = session('userInfo');
        $user_id = $session['user_id'];
        //检测库存
        $where=[
            'goods_id'=>$goods_id,
        ];
        $goodsInfo = DB::table('goods')->where($where)->first();
        if ($goodsInfo) {
            $where=[
                'goods_id'=>$goods_id,
                'user_id'=>$user_id,
            ];
            $updateInfo = [
                'buy_number'=>$buy_number,
                'update_time'=>time()
            ];
            $result = DB::table('cart')->where($where)->update($updateInfo);
            if ($result) {
                return ['code'=>'1','font'=>'修改数量成功'];
            }else{
                return ['code'=>'2','font'=>'发生未知错误，导致你的商品数量更改失败'];
            }
        }else{
            return ['code'=>2,'font'=>'商家商品库存不足，更改失败'];
        }
    }

    //购物车删除
    public function cartDel(){
        $goods_id = request()->goods_id;
        $session = session('userInfo');
        $user_id = $session['user_id'];
        $where = [
            'goods_id'=>$goods_id,
            'user_id'=>$user_id,
        ];
        $updateWhere=[
            'cart_status'=>2
        ];
        $del = DB::table('cart')->where($where)->update($updateWhere);
        if ($del){
            return ['code'=>1,'font'=>'删除成功'];
        }else{
            return ['code'=>2,'font'=>'删除失败'];
        }
    }

    //订单页面
    public function pay(){
        if (request()->isMethod('post')){
            $session = session('userInfo');
            if (!$session){
                return ['code'=>2,'font'=>'请先登陆'];
            }else{
                return ['code'=>1,'font'=>'提交成功'];
            }
        } elseif (request()->isMethod('get')) {
            $session = session('userInfo');
            if ($session==null){
                return redirect('user/login');
            }else{
                $goods_id = request()->goods_id;
                $goods_id=explode(',',$goods_id);

                $user_id = $session['user_id'];
                $goodsWhere=[
                    [ 'is_up','=',1],
                    ['cart_status','=',1],
                    ['user_id','=',$user_id],
                ];
//            dd($goodsWhere);
                $goodsInfo=DB::table('goods')
                    ->select('goods.goods_id','goods_name','self_price','market_price','goods_img','buy_number','goods_num','cart.create_time')
                    ->join('cart', 'goods.goods_id', '=', 'cart.goods_id')
                    ->where($goodsWhere)
                    ->whereIn('goods.goods_id',$goods_id)
                    ->orderBy("goods.goods_id",'desc')
                    ->get();
                //获取商品总价
                $countPrice = 0;
                foreach ($goodsInfo as $k => $v) {
                    $countPrice+=$v->self_price*$v->buy_number;
                }
                //获取收货地址
                $where = [
                    'is_default'=>1,
                    'user_id'=>$user_id,
                ];
                $is_default = DB::table('address')->where($where)->first();
//                dd($is_default);
//        dd(DB::getQueryLog());   //获取查询语句、参数和执行时间
                return view('cart/pay',compact('goodsInfo','countPrice','is_default'));
            }

        }
    }
}
