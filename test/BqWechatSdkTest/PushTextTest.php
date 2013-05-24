<?php
namespace BqWechatSdkTest;

use PHPUnit_Framework_TestCase;
use Zend\EventManager\EventManager;
use BqWechatSdk\Listener;
use BqWechatSdk\Event\Push;

class PushTextTest extends PHPUnit_Framework_TestCase
{
    protected $eventManager;
    protected $triggerPush = false;

    public function setup()
    {
        $GLOBALS["HTTP_RAW_POST_DATA"] = "
            <xml>
                 <ToUserName><![CDATA[toUser]]></ToUserName>
                 <FromUserName><![CDATA[fromUser]]></FromUserName> 
                 <CreateTime>1348831860</CreateTime>
                 <MsgType><![CDATA[text]]></MsgType>
                 <Content><![CDATA[this is a test]]></Content>
                 <MsgId>1234567890123456</MsgId>
             </xml>
            ";
        $this->eventManager = new EventManager();
        $this->eventManager->attach(Push::EVENT_PUSH, array($this, 'onPush'));
    }

    public function testPushTest()
    {
        $listenner = new Listener();
        $listenner->setEventManager($this->eventManager)->run();
        $this->assertTrue($this->triggerPush);
    }

    public function onPush($event)
    {
        $this->triggerPush = true;

        $message = $event->getMessage();
        $this->assertTrue($message->isText());
        $this->assertEquals('toUser', $message->getToUserName());
        $this->assertEquals('fromUser', $message->getFromUserName());
        $this->assertEquals('1348831860', $message->getCreateTime());
        $this->assertEquals('text', $message->getType());
        $this->assertEquals('this is a test', $message->getContent());
        $this->assertEquals('1234567890123456', $message->getMsgId());
    }
}
