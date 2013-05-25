BqWechatSdk
=============

介绍
----
BqWechatSdk是由PHP编辑写的微信公众平台SDK，实现了微信网址接入、接收推送消息和消息回复功能。使用事件驱动方式可以方便的在收到微信推送消息时实现自己的业务逻辑。

依赖
----
* PHP >= 5.3.3
* [ZF2/EventManager](https://github.com/zendframework/Component_ZendEventManager)

安装
----

### 使用composer安装
1. 将[BqWechatSdk](https://github.com/elvis-bi/BqWechatSdk)添加到项目根目录下的composer.json文件中。

    ```
    "require": {
        ...
        "elvis-bi/bq-wechat-sdk": "0.1.0Alpha"
        ...
    }
    ```


2. 运行composer安装

    `
    php composer.phar update
    `
3.  测试

    ```
    $cd {项目根目录}\vendor\BqWechatSdk\test
    $phpunit
    ```

使用
----
    ```
    ...
    use BqWechatSdk\Listener;
    use BqWechatSdk\Event\Listener\Valid;
    use BqWechatSdk\Event\Push;
    use BqWechatSdk\Event\Result;
    use BqWechatSdk\Message;
    use Zend\EventManager\EventManager;
    ...

    # 实例化事件管理器
    $eventManager = new EventManager();

    # 实例化并绑定网址接入监听器
    $validListener = new Valid();
    $validListener->setToken('你的微信token');
    $eventManager->attach($validListener);

    # 监听微信消息推送
    $eventManager->attach(Push::EVENT_PUSH, function($event) {
            ＃ 从事件中获取消息实例
            $message = $event->getMessage();
            $fromUsername = $message->getFromUserName();
            $toUsername = $message->getToUserName();

            # 判断收到的是否是文本消息
            if($message->isText()) {
                $content = $message->getContent();

                # 实例化一个音乐消息作为回复的消息
                $message = new Message();
                $message
                    ->setType(Message::TYPE_MUSIC)
                    ->setFromUserName($toUsername)
                    ->setToUserName($fromUsername)
                    ->setCreateTime(time())
                    ->setFuncFlag(0)
                    ->setMusicUrl('url')
                    ->setHQMusicUrl('hqurl')
                    ->setMusicTitle('title')
                    ->setMusicDescription('description');
                
                # 回复消息
                $result = new Result();
                $result->setMessage($message);
                return $result;
            }
        });

    $listener = new Listener();
    $listener
        ->setEventManager($eventManager)
        ->run();
    ```
