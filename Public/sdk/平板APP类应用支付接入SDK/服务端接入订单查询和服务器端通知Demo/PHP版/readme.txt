现在支付-中小开发者商户服务端接口服务接入指南

2014-10-20

====基本要求====
DEVPLAT_MCH_SDK(PHP)
├─api
│      notify.php---------------------------通知接口文件
│      query.php----------------------------查询接口文件
│      
├─conf
│      Config.php---------------------------服务器端接口配置文件
│      
├─log--------------------------------------log文件目录(文件名规则Log__年月日)
├─services
│      Core.php-----------------------------核心工具类
│      Net.php------------------------------HTTP通信类
│      Services.php-------------------------接口服务类
│      
└─utils
        Log.php------------------------------日志工具类
        Tools.php----------------------------普通工具类

==========================================================================

        请修改配置文件:conf/Config.php
		       您仅需修改app_id(应用ID)以及secure_key(商户秘钥)
