**dhsms**

`composer require dhsms/dhsms`

- 集合常用的短信接口,不用每次都复制方法什么的,旨在即装即用

## 聚知信

```$xslt
public static function juzhixin($data)
{
    $user_config = [            //申请信息配置
        'juzhixin' => [         //聚知信配置
            'account' => '',    //账号
            'password' => '',   //密码
            'subid' => ,        //用户id
        ]
    ];

    $code = mt_rand(1000, 9999);
    $config_biz = [
        'sendTime' => '',           //配置定时发送时间,不定时,为空
        'mobile' => '182********',  //手机号
        'content' => '【XXX】您的验证码是' . $code . ',请在5分钟内使用。'   //发送内容
    ];

    $sms = new Send($user_config);  //实例化短信发送对象

    $result = $sms->driver('juzhixin')->gateway('action')->send($config_biz);   //发送短信

    dd($result);    //打印发送结果
    
//    array:5 [
//      "returnstatus" => "Success"
//      "message" => "ok"
//      "remainpoint" => "98481"
//      "taskID" => "116459"
//      "successCounts" => "1"
//    ]
}

```

## 玄武短信

```$xslt
public static function xuanwu()
{
    $user_config = [            //申请信息配置
        'xuanwu' => [           //玄武短信配置
            'account' => '',    //账号
            'password' => '',   //密码
            'subid' => '',      //用户id 可以为空
        ]
    ];

    $code = mt_rand(1000, 9999);
    $config_biz = [
        'mobile' => '182********',
        'content' => '您的验证码是' . $code . ',请在5分钟内使用。'
    ];

    $sms = new Send($user_config);

    $result = $sms->driver('xuanwu')->gateway('action')->send($config_biz);

    dd($result);
    
    //0 表示发送成功
}

```
