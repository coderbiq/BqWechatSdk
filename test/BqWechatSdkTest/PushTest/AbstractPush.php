<?php
namespace BqWechatSdkTest\PushTest;

use PHPUnit_Framework_TestCase;
use Zend\EventManager\EventManager;
use BqWechatSdk\Listener;
use BqWechatSdk\Event\Push;

abstract class AbstractPush extends PHPUnit_Framework_TestCase
{
    protected $eventManager;
    protected $triggerPush = false;

    public function setup()
    {
        $GLOBALS["HTTP_RAW_POST_DATA"] = $this->getPushXml();
        $this->eventManager = new EventManager();
        $this->eventManager->attach(Push::EVENT_PUSH, array($this, 'onPush'));
    }

    public function testPushTest()
    {
        $listenner = new Listener();
        $listenner->setEventManager($this->eventManager)->run();
        $this->assertTrue($this->triggerPush);
    }

    public function getToUserName()
    {
        return 'toUser';
    }

    public function getFromUserName()
    {
        return 'fromUser';
    }

    public function getCreateTime()
    {
        return '1348831860';
    }


    public function onPush($event)
    {
        $this->triggerPush = true;

        $message = $event->getMessage();
        $this->assertEquals($this->getToUserName(), $message->getToUserName());
        $this->assertEquals($this->getFromUserName(), $message->getFromUserName());
        $this->assertEquals($this->getCreateTime(), $message->getCreateTime());
    }

}
