<?php
namespace BqWechatSdkTest\PushTextReturnTest;

use BqWechatSdk\Message;
use BqWechatSdk\Event\Result;

class MusicTest extends PushTextReturnTestCase
{
    public function testPushTextReturnMusion()
    {
        $output = $this->getOutput();

        $this->assertInstanceOf('SimpleXMLElement', $output);
        $this->assertEquals('fromUser', $output->FromUserName);
        $this->assertEquals('toUser', $output->ToUserName);
        $this->assertEquals('123456789', $output->CreateTime);
        $this->assertEquals('0', $output->FuncFlag);
        $this->assertEquals('music', $output->MsgType);
        $this->assertEquals('url', $output->Music->MusicUrl);
        $this->assertEquals('hqurl', $output->Music->HQMusicUrl);
        $this->assertEquals('music title', $output->Music->Title);
        $this->assertEquals('music description', $output->Music->Description);
    }

    public function onPush($event)
    {
        $message = new Message();
        $message
            ->setType(Message::TYPE_MUSIC)
            ->setFromUserName('fromUser')
            ->setToUserName('toUser')
            ->setCreateTime(123456789)
            ->setFuncFlag(0)
            ->setMusicUrl('url')
            ->setHQMusicUrl('hqurl')
            ->setMusicTitle('music title')
            ->setMusicDescription('music description');
        $result = new Result();
        $result->setMessage($message);
        return $result;
    }
}
