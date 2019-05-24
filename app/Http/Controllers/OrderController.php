<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class OrderController extends Controller{
    public function address(){
        $addressInfo = $this->getAddressInfo();
        return view('order/address',compact('addressInfo'));
    }
    //新增收货地址
    public function shipping(){
        //获取所有的省份信息作为下拉菜单的值
        $provinceInfo = $this->getAreaInfo(0);
//        dd($provinceInfo);
        return view('order/shipping',compact('provinceInfo'));
    }
    public function getAreaInfo($pid){
        $where=[
            'pid'=>$pid
        ];
        $province = DB::table('area')->where($where)->get();
//        dd($province);
        if (!empty($province)) {
            return $province;
        }else{
            return false;
        }
    }
    //执行添加收货地址
    public function shippingDo(){
        $session = session('userInfo');
        $user_id = $session['user_id'];
        $data = request()->except("_token");
        $data['user_id'] = $user_id;
        $data['create_time'] = time();
        $data['address_email'] = 123456;
        $addressInfo = DB::table('address')->insert($data);
        if ($addressInfo){
            return ['code'=>1,'font'=>'添加成功'];
        }else{
            return ['code'=>2,'font'=>'添加失败'];
        }
    }

    //设为默认
    public function addressdefault(){
        $address_id = request()->address_id;
        $session = session("userInfo");
        $user_id = $session['user_id'];
        $updateWhere = [
            'user_id'=>$user_id
        ];
        $where=[
            'user_id'=>$user_id,
            'address_id'=>$address_id,
        ];
        $defaultWhere=[
            'is_default'=>1
        ];
        DB::beginTransaction();
        $addressInfo = DB::table('address')->where($updateWhere)->update(['is_default'=>2]);
        $res = DB::table('address')->where($where)->update($defaultWhere);
//        dd($res);
        if ($addressInfo!==false&&$res) {
            DB::commit();
            if ($res) {
                return ['code'=>1,'font'=>'设置成功'];
            }else{
                return ['code'=>2,'font'=>'设置失败'];
            }
        }else{
            DB::rollback();
        }
    }
    //处理收货地址
    public function getAddressInfo(){
        $session = session('userInfo');
        $user_id = $session['user_id'];
        $where=[
            'user_id'=>$user_id,
            'address_status'=>1
        ];
        // dump($where);exit;
//        $area_model = model('Area');
        $addressInfo = DB::table('address')->where($where)->orderBy('is_default','asc')->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
//         dump($addressInfo);exit;
        if (!empty($addressInfo)) {
            foreach ($addressInfo as $k => $v) {
                //处理收货地址的省市区
                $addressInfo[$k]['province']=DB::table('area')->where(['id'=>$v['province']])->value('name');
                $addressInfo[$k]['city']=DB::table('area')->where(['id'=>$v['city']])->value('name');
                $addressInfo[$k]['area']=DB::table('area')->where(['id'=>$v['area']])->value('name');
            }
            return $addressInfo;
        }else{
            return false;
        }
    }
    //获取市县
    public function getArea(){
        $id = request()->id;
        if (empty($id)) {
            return ['code'=>2,'font'=>'请选择一件商品'];
        }
        $areaInfo = $this->getAreaInfo($id);
//        dd($areaInfo);
        return ['areaInfo'=>$areaInfo,'code'=>1];

    }

    //订单号 规则 时间戳加随机五位数
    public function getOrderNo(){
        return time().rand(11111,99999);
    }

    // 检测数量是否超过库存
    public function checkGoodsNum($goods_id,$old_buy_number,$buy_number,$type=1){
        $where = [
            'goods_id' => $goods_id
        ];
        $goods_num = DB::table('goods')->where($where)->value('goods_num');
        if(($old_buy_number+$buy_number)>$goods_num){
            $n = $goods_num-$old_buy_number;
            if ($type==1) {
                return ['code'=>2,'font'=>'库存不足，最多还能购买'.$n.'件'];
            }else{
                return false;
            }
        }else{
            return true;

        }
    }

    //提交订单
    public function submitPay(){
        $session = session('userInfo');
        $user_id = $session['user_id'];
        //判断是否登陆
        if ($session==null){
            return redirect('user/login');
        }
        $goods_id = request()->goods_id;
        $goods_id=explode(',',$goods_id);
        $address_id = request()->address_id;
        $pay_type = request()->pay_type;
        if (empty($goods_id)) {
            return ['code'=>'2','font'=>'请选择一件商品'];
            exit;
        }
        if (empty($pay_type)) {
            return ['code'=>'2','font'=>'请选择一种支付方式'];
            exit;
        }
        if (empty($address_id)) {
            return ['code'=>'2','font'=>'请选择一种收获方式'];
            exit;
        }
        //开启事务 把订单信息存入订单表
        DB::beginTransaction();
        try{
            //订单号
            $orderInfo['order_no']=$this->getOrderNo();
            //结算的商品数据
            $goodsWhere=[
                [ 'is_up','=',1],
                ['user_id','=',$user_id],
            ];
            $goodsInfo=DB::table('cart')
                ->select('goods.goods_id','goods_name','self_price','goods_img','buy_number')
                ->join('goods', 'cart.goods_id', '=', 'goods.goods_id')
                ->where($goodsWhere)
                ->whereIn('cart.goods_id',$goods_id)
                ->get();
            //把对象改为数组
            $goodsInfo = json_decode(json_encode($goodsInfo), true);
//            dd($goodsInfo);
            // 结算的商品的总价
            $count = 0;
            foreach ($goodsInfo as $k => $v) {
                $count+=$v['buy_number']*$v['self_price'];
            }

            $orderInfo['order_no']=$this->getOrderNo();
            $orderInfo['order_amount']=$count;
            $orderInfo['pay_type']=$pay_type;
            $orderInfo['user_id']=$user_id;
            $orderInfo['create_time'] = time();
            $orderInfo['update_time'] = time();
            $res = DB::table('order')->insert($orderInfo);
            if(!$res){
                DB::rollback();
                return ['code'=>'2','font'=>'订单信息写入失败'];
            }
            //拿到订单表的id
            $order_id = DB::getPdo()->lastInsertId();
            //把订单商品信息写入订单详情表
            foreach ($goodsInfo as $k => $v) {
                $res1 = $this->checkGoodsNum($goods_id,0,$v['buy_number'],2);
                if (!$res1) {
                    DB::rollback();
                    return ['code'=>'2','font'=>$v['goods_name'].'库存不足,请重新选择'];
                }
                $goodsInfo[$k]['order_id']=$order_id;
                $goodsInfo[$k]['user_id']=$user_id;
                $goodsInfo[$k]['create_time'] = time();
                $goodsInfo[$k]['update_time'] = time();
            }
            $res2 = DB::table('order_detail')->insert($goodsInfo);
            if (!$res2) {
                DB::rollback();
                return ['code'=>'2','font'=>'写出订单表失败'];
            }
            //把订单的收货地址存入收货地址表
            $where=[
                'address_id'=>$address_id
            ];
            $addressInfo = DB::table("address")->select('address_name','address_tel','address_email','address_detail','province','city','area')->where($where)->get();
            if (empty($addressInfo)) {
                DB::rollback();
                return ['code'=>'2','font'=>'收货地址不存在'];
            }
            $addressInfo = json_decode(json_encode($addressInfo), true);
//            dd($addressInfo);
            foreach ($addressInfo as $k=>$v){
                $addressInfo[$k]['order_id']=$order_id;
                $addressInfo[$k]['user_id']=$user_id;
                $addressInfo[$k]['create_time'] = time();
                $addressInfo[$k]['update_time'] = time();
            }
            $res3 = DB::table('order_address')->insert($addressInfo);
            if (!$res3) {
                DB::rollback();
                return ['code'=>'2','font'=>'写入收货地址失败'];
            }
            //清空购物车结算的商品数据
            $where=[
                'user_id'=>$user_id,
            ];
            $updateWhere=[
                'cart_status'=>2,
            ];
            $res4 = DB::table('cart')->where($where)->whereIn('goods_id',$goods_id)->update($updateWhere);
            if (!$res4) {
                DB::rollback();
                return ['code'=>'2','font'=>'清空购物车商品数据失败'];
            }
            //减少商品表中商品的库存
            $goodsInfos=DB::table('cart')
                ->select('goods.goods_id','goods_name','self_price','goods_img','buy_number','goods_num')
                ->join('goods', 'cart.goods_id', '=', 'goods.goods_id')
                ->where($goodsWhere)
                ->whereIn('cart.goods_id',$goods_id)
                ->get();
            $goodsInfos = json_decode(json_encode($goodsInfos), true);
//            dd($goodsInfos);
            $goodsInfo_id = array_column($goodsInfos,'goods_id');
            foreach ($goodsInfos as $k => $v) {
                        $updatewhere=[
                    'goods_num'=>$v['goods_num']-$v['buy_number'],
                ];
                //bug2 一但修改 所有数据都修改 $updatewhere 没有起作用
                $res5 = DB::table('goods')->whereIn('goods_id',$goodsInfo_id)->update($updatewhere);
                if (!$res5) {
                    DB::rollback();
                    return ['code'=>'2','font'=>'减少库存数量失败'];
                }
            }
            DB::commit();
            return $arr = ['code'=>1,'font'=>'订单提交成功','order_id'=>$order_id];
            echo json_encode($arr);
        }catch(\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return ['code'=>'2','font'=>'订单信息写入失败'];
        }
        return ['code'=>'1','font'=>'订单信息成功'];
    }

    //
    public function success(){
        $order_id = request()->order_id;
        $session = session("userInfo");
        $user_id = $session['user_id'];
        $where=[
            'user_id'=>$user_id,
            'order_id'=>$order_id,
        ];
        $orderInfo = DB::table('order')->where($where)->first();
        $orderInfo = json_decode(json_encode($orderInfo), true);
        $addressInfo = $this->getAddressInfo();
        return view('order.success',compact('orderInfo','addressInfo'));
    }

    //pc 支付
    public function pcalipay($order_id=0){
//        echo 123;die;
        $config  = config('alipay');
//        echo $config;die;
        require_once app_path('Tools/alipay/pagepay/service/AlipayTradeService.php');
//          dd(app_path('Tools\alipay\pagepay\buildermodel\AlipayTradePagePayContentBuilder.php'));
//          dd(app_path('Tools\alipay\pagepay\service\AlipayTradeService.php'));
        require_once app_path('Tools/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');

        //商户订单号，商户网站订单系统中唯一订单号，必填
        $session = session("userInfo");
        $user_id = $session['user_id'];
        $where=[
            'order_id'=>$order_id,
            'user_id'=>$user_id,
        ];
        $orderInfo = DB::table("order")->where($where)->first();
//        dd($orderInfo);
        $out_trade_no = $orderInfo->order_no;
//        dd($out_trade_no);

        //订单名称，必填
        $subject = "寿司小铺";

        //付款金额，必填
        $total_amount = $orderInfo->order_amount;
//        dd($total_amount);
        //商品描述，可空a
        $body =$orderInfo->order_text;
//        dd($body);
        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
//        dd($payRequestBuilder);
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);

        $aop = new \AlipayTradeService($config);
//        dd($aop);

        /**
         * pagePay 电脑网站支付请求
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @param $notify_url 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
         */
        $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
//        dd($response);
        //输出表单
        var_dump($response);
    }

    //支付成功后返回
    public function returnAlipay(){
        /* *
         * 功能：支付宝页面跳转同步通知页面
         * 版本：2.0
         * 修改日期：2017-05-01
         * 说明：
         * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。

         *************************页面功能说明*************************
         * 该页面可在本机电脑测试
         * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
        */
//        echo 123;die;
        $config  = config('alipay');
        require_once app_path('Tools\alipay\pagepay\service\AlipayTradeService.php');



        $arr=$_GET;//同步
//        dd($arr);
        $alipaySevice = new \AlipayTradeService($config);
//        dd($alipaySevice);
        $result = $alipaySevice->check($arr);
//        dd($result);
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码

            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            //商户订单号
            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
//            dd($out_trade_no);
            //商户交易金额
            $total_amount = htmlspecialchars($_GET['total_amount']);
            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);

            $seller_id = htmlspecialchars($_GET['seller_id']);

            echo "验证成功<br />支付宝交易号：".$trade_no."商户订单号".$out_trade_no."商户交易金额".$total_amount;
//            return view('index/index');
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "验证失败";
        }
    }

}