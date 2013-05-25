<?php
namespace BqWechatSdkTest\PushTest;

use PHPUnit_Framework_TestCase;
use Zend\EventManager\EventManager;
use BqWechatSdk\Listener;
use BqWechatSdk\Event\Push;

class EventTest extends PHPUnit_Framework_TestCase
{
    protected $eventManager;
    protected $triggerPush = false;
    protected $eventType = null;

    public function setup()
    {
        $this->eventManager = new EventManager();
        $this->eventManager->attach(Push::EVENT_PUSH, array($this, 'onPush'));
    }

    /**
     * @dataProvider pushTestData
     */
    public function testPushTest($xml, $eventType)
    {
        $GLOBALS["HTTP_RAW_POST_DATA"] = $xml;
        $this->eventType = $eventType;

        $listenner = new Listener();
        $listenner->setEventManager($this->eventManager)->run();
        $this->assertTrue($this->triggerPush);
    }

    public function pushTestData()
    {
        $xml = "
            <xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[FromUser]]></FromUserName>
                <CreateTime>123456789</CreateTime>
                <MsgType><![CDATA[event]]></MsgType>
                <Event><![CDATA[%s]]></Event>
                <EventKey><![CDATA[EVENTKEY]]></EventKey>
            </xml>           
            ";

        return array(
            array(sprintf($xml, 'subscribe'), 'subscribe'),
            array(sprintf($xml, 'unsubscribe'), 'unsubscribe'),
            array(sprintf($xml, 'CLICK'), 'CLICK'),
        );
    }

    public function onPush($event)
    {
        $this->triggerPush = true;

        $message = $event->getMessage();
        $this->assertEquals('toUser', $message->getToUserName());
        $this->assertEquals('FromUser', $message->getFromUserName());
        $this->assertEquals('123456789', $message->getCreateTime());

        $this->assertTrue($message->isEvent());
        $this->assertEquals('EVENTKEY', $message->getEventKey());

        switch($this->eventType)
        {
        case 'subscribe':
            $this->assertTrue($message->isSubscribeEvent());
            break;
        case 'unsubscribe':
            $this->assertTrue($message->isUnsubscribeEvent());
            break;
        case 'CLICK':
            $this->assertTrue($message->isClickEvent());
            break;
        }
    }
}
