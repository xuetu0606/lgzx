<?php
$config = array (
    //应用ID,您的APPID。
    'app_id' => "2016071801635130",

    //商户私钥，您的原始格式RSA私钥
    'merchant_private_key' => "MIICXgIBAAKBgQDK2884b/mWSMKpu5pxwfAgyTRGItCwO+vw6kNwKwxAbd2wpqjZbxhGXHUwRrLJe9lAMbF7PZlnwtf13ddKh3lxN5fSCJFkid7V6gQCJH1I0pHp6/LynrIoAjTTmG5Dn8cLt3Epm9inBNhp1oPVe2YI0LdHVircRKBjVdOcTerUDwIDAQABAoGBAMUFVa5Hus3GXyIArhDcPj9pi1avC6aOnCoBLHxtotmUmyKtywJbDuWPeNXpZE2h9q+NVAYRHsQTDjKiQi4Fg+C/oF+kDtpV+tI1ht2hbAhaWxgMam5SvfcuQFIKpjXDLcmxkomE7tJGm4KsyZZoY8P2rK15wG6Uk3gB/I7FotXxAkEA/uG1ZzIPBI/a57YyycvsdHfeglcpGbT9TNS8NWiLsk+JGQTPMphEQlwpr/NwhB3HUCBiN2Js5L88G/Pb9rs2OQJBAMu/qrguzMFvjrFk+cW97iUc+ZXU75UVYyCWAyDiegU8/uMVsj190/ei0+xbiplo31AnnZalGuXYiTDCD/lbHIcCQF9tcDaf1mGV3pasb52AHRqKGqPgMEIwsjmG2KSCbPMotiLI2y6NNdlGmlEHKxQ79fi49yzXS//k3YN1rOBWvXkCQQCacP2qQSdJ1RL3mo/N+SskDLOPhGnauux5zdwvOBzADb0zSsXh4Jgk1NMJDVag9KKZcn38q8gYw6syP1e2bv7PAkEA1FVREbzc0QlyfbuOufAYpr5KhmDHmrvM7xS3wdR/bZ2NhOmutIwF+qdSBouKUEEaMFg2Y9nybae1gV2z+Xov0Q==",
    
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
    'alipay_public_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB"

);