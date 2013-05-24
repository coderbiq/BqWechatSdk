<?php
namespace BqWechatSdkTest\PushTextReturnTest;

use BqWechatSdk\Message;
use BqWechatSdk\Event\Result;

class TextTest extends PushTextReturnTestCase
{
    public function testPushTextReturnText()
    {
        $outputObj = $this->getOutput();
        $this->assertInstanceOf('SimpleXMLElement', $outputObj);
        $this->assertEquals('text', $outputObj->MsgType);
        $this->assertEquals('test content', $outputObj->Content);
        $this->assertEquals('0', $outputObj->FuncFlag);
        $this->assertEquals('123456789', $outputObj->CreateTime);
        $this->assertEquals('fromUser', $outputObj->FromUserName);
        $this->assertEquals('toUser', $outputObj->ToUserName);
    }

    public function onPush($event)
    {
        $message = new Message();
        $message
            ->setType(Message::TYPE_TEXT)
            ->setFromUserName('fromUser')
            ->setToUserName('toUser')
            ->setContent('test content')
            ->setCreateTime(123456789)
            ->setFuncFlag(0);
        $result = new Result();
        $result->setMessage($message);
        return $result;
    }
}
