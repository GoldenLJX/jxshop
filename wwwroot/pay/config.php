<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016082000291715",

		//商户私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEA13q3C2UCV27JtL5m0/+TNSl2uxNnDhKqBLGEr63i5Ae9v7V+u7SlD7VM+5by8G4bLdvRdgQdcJAHY4R718uXUUzlLk9lQ9jD4UAUzXZcNYRX/2wdOY9CxfwwhTVSAbJWxfZxVtbj63XtwSM3G+63MO99+YuHCRBcUctXnpFUEgmbO3lQf7siu6wT3W1D6yuNJBG7m8BecWOHw8BBgFzBucDj0E2GnwHYJOhdLLjfIkF1SP6eCd7tY4h940Bq613uX8N0Q4yzxU9ZvLF6kHnKCbuug3euu7KXjL5oTJvHzCDN1ftpZz2jZDcEF0DUf/gTODEvL3q4kMF2aSTSDAyjSwIDAQABAoIBAQDE4gpn7eYiz0ab0DESWX4+3+DtdAAAmssgOLcc8gvTAMO+a+4dQiRjYuuxIa5eQqywzR3o8D+Z/u/RXVbuyMY88b6h/sdvI5tur+eSCCieeYsSBc36Lsz7K7+Fpz+D71hbzx6mEvjzxq/zfeK3sflOTDVVkshSXtGLpvkrGGyxgMnlwYirNHQXlUYtFs+u5fXwKBAxM45Q65dQqF2et4EQQy3gOZzAhB0mLRvHNs7wn74nNiQr0cjYYDDrg4OcMA8ya9hTab5Ykjz7a8ve1rLMNqW+D4WZT+eK+F0lvLbtdy7WITbw46JmDJZKRjgLUsKAC7O9lwilC8UC+ZzYX1UpAoGBAPWR/gPUHUp7RolF3RBvEvw1nrC6DJh3xRRlWdgnbU9DvQvHVALFQYNqCvCvvlB+4k8E6yBSmkJbnfPQ8nEbTk7leJ0zirnw6l3tzgSfIegcb2S57tJGbdsJMGkZ3s/qhLpvnz5Oa0MsXloxLkIkRg1mrLQty1mL2PF7SaEJau09AoGBAOChjb2bpxUBZ7OL4AX5CMqjCSrCoa3ABBqkLRJzT/1I1qjGn1BX1Ic32hxZZgIOhEjKzUQR6ypCMd5vKK3OYvccovTJWQpPGxKSC6vmosn1+ppsCTpntbmOV11BV7eYW923KyqUSABAQ6BZQFgmVpC252MMI4RvVhUa8HGnomsnAoGAc0U7UjrAIRUqsAceVLd+1uqoedZrUSpvVTqZ6M/hDKMEW0IOmlpTfUdKqV4lXI2i12q8n+iGRn3Q8AD1vMgPgxNOAaSPCucebEbTPPIhrV2joEly5DtxF68BjWQ6Zah08zqwKkQPL3HlPDr3ts5mH6ZBjTYtzPPLOtcfYbsU+RUCgYB+OQmGk+JNIV7+OwkFEizogLhz+K4VDiLAPaS+C2HVN4q3h/SZluDromzDJVD2suWOabbyGweD1XJkRR4cnC5sIQFIf6Oy8USLKNm6HH048ymAgFinIwOwYtWgp0j893YXngd5g5z51yKpBb3sSo61/rECrR2AG3fJoDugAcx4XQKBgQCEpGiujmcb/CpA0RR8Jf+Hp/jOO5DxkMozAdmuo6KXr+Qu41qenyM4NfKR8ReTdhGJ/Wn5QNnm8DQKgnRMaVfOovgXb0zWK7QZ7fxjdzre93Xen0FVq312/m5JeDn/hkoCLsN969Av58YrAKvzFu11XS9ZqEYPhoyV8e5HXTe/Nw==",
		
		//异步通知地址
		'notify_url' => "http://localhost/pay/alipay.trade.page.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://localhost/pay/alipay.trade.page.pay-PHP-UTF-8/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "",
);