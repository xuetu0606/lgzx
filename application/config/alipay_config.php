<?php
$config = array (
    //应用ID,您的APPID。
    'app_id' => "2016071801635130",

    //商户私钥，您的原始格式RSA私钥
    'merchant_private_key' => "MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAMrbzzhv+ZZIwqm7mnHB8CDJNEYi0LA76/DqQ3ArDEBt3bCmqNlvGEZcdTBGssl72UAxsXs9mWfC1/Xd10qHeXE3l9IIkWSJ3tXqBAIkfUjSkenr8vKesigCNNOYbkOfxwu3cSmb2KcE2GnWg9V7ZgjQt0dWKtxEoGNV05xN6tQPAgMBAAECgYEAxQVVrke6zcZfIgCuENw+P2mLVq8Lpo6cKgEsfG2i2ZSbIq3LAlsO5Y941elkTaH2r41UBhEexBMOMqJCLgWD4L+gX6QO2lX60jWG3aFsCFpbGAxqblK99y5AUgqmNcMtybGSiYTu0kabgqzJlmhjw/asrXnAbpSTeAH8jsWi1fECQQD+4bVnMg8Ej9rntjLJy+x0d96CVykZtP1M1Lw1aIuyT4kZBM8ymERCXCmv83CEHcdQIGI3Ymzkvzwb89v2uzY5AkEAy7+quC7MwW+OsWT5xb3uJRz5ldTvlRVjIJYDIOJ6BTz+4xWyPX3T96LT7FuKmWjfUCedlqUa5diJMMIP+VschwJAX21wNp/WYZXelqxvnYAdGooao+AwQjCyOYbYpIJs8yi2IsjbLo012UaaUQcrFDv1+Lj3LNdL/+Tdg3Ws4Fa9eQJBAJpw/apBJ0nVEveaj835KyQMs4+Eadq67HnN3C84HMANvTNKxeHgmCTU0wkNVqD0oplyffyryBjDqzI/V7Zu/s8CQQDUVVERvNzRCXJ9u4658BimvkqGYMeau8zvFLfB1H9tnY2E6a60jAX6p1IGi4pQQRowWDZj2fJtp7WBXbP5ei/R",

    //异步通知地址
    'notify_url' => "http://". $_SERVER['HTTP_HOST'] ."/pay/notify_url",

    //同步跳转
    'return_url' => "http://". $_SERVER['HTTP_HOST'] ."/pay/return_url",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB",


);