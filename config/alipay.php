<?php
return [
    //应用ID,您的APPID。
    'app_id' => "2016092100561897",

    'seller_id' => "2088102176605972",

    //商户私钥
    'merchant_private_key' => "MIIEowIBAAKCAQEAy2xnH2Yoax6t3FZH5VKJUIEINoP3DE7stdivc/AcwtoG2nJCwt4E5kmS8zSjyuHnp44MZeq1Suv/fGXZTkgqspEGZYWMhkQ4N8lYTdkB7HfMPbnPX23w1jgWdqBgXBMHAXOOlTELhW5y8+SKJ7pumLRdohI2AJmXbyeaa5zwIW7c24jp4Wad4YND+oa5n+/ZCiYJnTYtz6oa2upQgDQv8cHssoxIyRZXqKXpqyAotN7I8Pka1Fn45E8s7dyzKxOioKTQLQw9zWOh6qJGa0ZAvnHpxgLNVGUOC25MiGtlwHVNjVfTjiy80xHtp64WSXO/b8ej7bp6XHTBWSGV8W/ikwIDAQABAoIBACZTDv6YZYcA6ap4SuVGbn5PQPfcVt/nwqrj3vJNy21eXCotmqxR3cRxGhFd2nnvo5Aqr+VHmc46thB+s7kO2ZR4xCa+SWJGWf0QnuVTvAwL6du7NPl6ogQJ3xmMT3spTomUdsleyxfhXiDa7rhbZFi6qmVNXwUv6prTcEFT+N2jSdGTDdOeqtzIWQApEdQkWDETzMFSeLErWNeqbxSVKxP8GxUpr3sjlsuyYuNAjMIhDFNMnVux8Cx9A2/SAKPvc5eVJgey0Kld2Wc2hBpiYExDUd+FAgA+EeIiu/WssHUTqde3WOYSAoSArxQ1t5+ACNOWexhccVy+4SKmyVv9cRECgYEA/qjW/QfU/QlY571x6M9NtmRyHrpmsknCSAkpiQyLDXAVf2vkZMNCr/07rBy4cYItvTfMnpzV0gUG9fWzQPS4BImBzG2a7mpOUI+l7YFn21AQ8Vzi7c77tDDB8/ld2ZoLTAb/mdUQadhSSS3iBozWQSUQoSahGy5LdqSNy/3lh6sCgYEAzH6FZsVyZKpm0xL4NAre9ho0wr4rT+gZlZecGzdHXH7pgdadgq5pZUt53JI2CYncRCyZl+53B7NSlUpx9p6a/WHTQoMcS0x5DVObLqkA52CT+P6YyCDUmq85IFdOm3onw2C1eSjoue7NQKUSnzsT4F7XTMel1ALih6bVGZ16iLkCgYEA6ao2ijnzfrJi91BnAr2kiuUjqXpT3Oe88qglinEN7iiYMTDogmR//keXx1cbDlvqaCKZCDjUIT8noevurH1flBowFUnEzVqRvW3xTDpe92dCBJW8S4SOhEnwzVJUgOPN1dbeFWLhCp3I8wi8ylHUDjZaSePOE8ioyZY33aN8Rr0CgYADt1znRDlS+QHLXjHiiDwLDujcjSYuWpJ0dH/iwrtqQ+gscuED6fWCYL/DMWkH/VhiaMkVyMCjBDBBBExT5gf9CNUVBVrzR11/z4AndezNR6UIxl+ya15RvVN1cgC8tJiaZVyG6iZokp1qSlWvTRyMXEzfWVV7J95EBtUilQkQCQKBgBboMhe143cjMBHIfC+HULS5DkQx/2UwNeNA2u9tzN5ZDaCEE6PSDDdJCxVJxBwy5608xTdnu30g7tDCVBsPaAOXxNtgHBfj+tfNTA1l+ztR/OXMfU7uX75MGCw0MHbm1yA3hF2Pt/xSVqW5fyrgAr3ZBclAKRG00OEYDA1geC01",

    //异步通知地址
    'notify_url' => "http://39.96.39.134",

    //同步跳转
    'return_url' => "http://www.ecshop.com/order/returnAlipay",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAy2xnH2Yoax6t3FZH5VKJUIEINoP3DE7stdivc/AcwtoG2nJCwt4E5kmS8zSjyuHnp44MZeq1Suv/fGXZTkgqspEGZYWMhkQ4N8lYTdkB7HfMPbnPX23w1jgWdqBgXBMHAXOOlTELhW5y8+SKJ7pumLRdohI2AJmXbyeaa5zwIW7c24jp4Wad4YND+oa5n+/ZCiYJnTYtz6oa2upQgDQv8cHssoxIyRZXqKXpqyAotN7I8Pka1Fn45E8s7dyzKxOioKTQLQw9zWOh6qJGa0ZAvnHpxgLNVGUOC25MiGtlwHVNjVfTjiy80xHtp64WSXO/b8ej7bp6XHTBWSGV8W/ikwIDAQAB",
];