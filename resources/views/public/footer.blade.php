<div class="footNav">
    <dl>
        <a href="{{url('/')}}">
            <dt><span class="glyphicon glyphicon-home"></span></dt>
            <dd>微店</dd>
        </a>
    </dl>
    <dl>
        <a href="{{url('/goods/goodslist')}}">
            <dt><span class="glyphicon glyphicon-th"></span></dt>
            <dd>所有商品</dd>
        </a>
    </dl>
    <dl>
        <a href="{{url('/cart/cartlist')}}">
            <dt><span class="glyphicon glyphicon-shopping-cart"></span></dt>
            <dd>购物车 </dd>
        </a>
    </dl>
    <dl>
        <a href="{{url('/user/user')}}">
            <dt><span class="glyphicon glyphicon-user"></span></dt>
            <dd>我的</dd>
        </a>
    </dl>
    <div class="clearfix"></div>
</div><!--footNav/-->
</div><!--maincont-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/style.js"></script>
<!--焦点轮换-->
<script src="/js/jquery.excoloSlider.js"></script>
<script>
    $(function () {
        $("#sliderA").excoloSlider();
    });
</script>
</body>
</html>