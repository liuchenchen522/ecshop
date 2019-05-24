<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016092100561897",

		//商户私钥
		'merchant_private_key' => "MIIEogIBAAKCAQEAxNOweZlb74FIhTP5yVnbMuO6Y1kvUVa/ECvVq4A7yuBypxUNwxet1R7VuZZvpygBnU3iNqdQ/VqT0QVV6P1WqZrTa6n3S9g3v1ml1shhTkCtelCFJ2OH/gWk1nL9deqosmqqThsIDJUThFv09HuDGdOLyipSPSWRWb3Wej+NopAdSi/8exTlIK3X3ZLZAJuWgl57upODlQzjHecuOlbaZCsnUL/8c5XdBM6urxp0vJbRyWmWAGu1uqSRdywNy3Jsj99btyoRufQrybm/qt9P/RJzZ1G+twkkqb59Gz1Bz53t9gvpuepn7n3Mye9gW82ICd2pVovcThJv7mhoQ8NzrwIDAQABAoIBACPoSqWkaLVE7KoAVW16Sxb5nKNLPeqk3K5ikNR8zGuyjrgUizIwO7JJscvtuejQz5qW/tHhrFDMGXNkecvLi+fdKvzVQRxBEcqC3FJWtAnGmt9ZmTEaY1DgTrYgvESqzqPd+bvOCqXg/HKFJCcF8WDgyvvSxLYLCH1KuLoMphYlyn1E1IjaKvxjyD1GmWMBw92a8xyPSyiWPyFyHLg4j1N06Wl/GFZ+CYxqycFMawwEs7EMdQZTO+o3nRv1uz754gpPRA4vJR/S0Fh6XlN+PkVRo5V5InFHXVUDZIyWZCDuC75sE78oS2rKxFMrVUX+Xy+a5+pCiXG30NGByIU7DkECgYEA6MH3uXJdetttWwDFNaI3lch/BIVcBpfj0iFwHc+Pnqclhrt6vCZHEX5R7BaCukCjgwh/Uc/jAkQ4rfATvARq6ogYezks+K8elok/7IwQvBRGByKAq1HWR37M44Q8PGqHVd4V6Hv7ryBjDSrIU3eMC8DV7zptKqTWxKeBMb8+inkCgYEA2Hs3R/cvwM4kjaByXd/SbStLn3j/extzElz2i/TQfjNLwP3rtdyhcaDx9wKpyutMIVKvCiWQyiDIvrVekTodf18GCLch8OVSdAks2nI3HY3Xy3EqqistPa8q80NZZNISIENNZ4VyemNBZPcepb5oQiyM6z8Y4FVbeb6VHo64ZWcCgYA9tF5V/WmmzlEZVQTzCQQvYy25JxmUbePpqw+r94CdkLY0F7Ob+ZHRo2lYa0dQ1R4D+Na3+6K00R0tj33L1Gf7sQS8dhXj/5jeU5hsv10YX0+JSK5PvKxP29+5WS8W3S7vpqasMWIxtSZNMVBWQFUSMJcGiriyG20MSVPIumh8EQKBgAw1Zri4SAknlwgltE13AfcGKg2kVUQsGCFA/OaHt/pmCi+oIlLvTmuKGBtGGy1Gd9SpRRXdaHz9vFSFBgBKtr8oLL7xFQjw5eWFXvIy3sjb5v+iMjXGmZaQ+msdsTzuW/dV1FeyPvKIBngbN69BPb/9ozThKhX8ulvzU5WVlvChAoGADNVk0rApD9np6MNp6UPQeMtifxcFzN855AtheOTIh5z+6Fkg3/cRE+lZcYAAMfHM8JaYP1/9Qb8r7wSLGJle5cxxAA50Ce+4dobXtP+X7aXvpFFpnJ0Oo+T3iX45He+bPqHT5a4EpjwHAs9B2A4EPVc57l52og2brZKUrmOr5oE=",
		
		//异步通知地址
		'notify_url' => "http://47.93.194.136",
		
		//同步跳转
		'return_url' => "http://www.blog.com/aa",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtl4MHKxWHJOyFYBxaPxbgVib5h8eVak5iP3NZFWsT4OqtuDwOEHv19+JYhBVugxfvyfrpCoARvgGrGB6NesiuwgyYjoxiUfOaeRcF+cl1sIjMvXLRiR+gHFhLNAOB9Oay9cAydinmbVGaOgeEok5dOtOuLmwoAyiqxx1kb9VfJcYnDyMJZQ/6tgvYgxKNG43DW80qD9TbK2qsXpK/03kyhtEiDJwsf2mTMnqSmkVyh9DIr9V/QD1w4RCicM7BGlhCwbbUbclHPFfUIY7vKunlII4IxD1ASzEhegKBCl2sv2MF8mtl/NqjDYETs5Ci4L4/6nObZK9QjkfZE6bjsb+2QIDAQAB",
);