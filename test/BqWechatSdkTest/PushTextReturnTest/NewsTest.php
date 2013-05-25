<?php
namespace BqWechatSdkTest\PushTextReturnTest;

use BqWechatSdk\Message;
use BqWechatSdk\Message\News\Item;
use BqWechatSdk\Event\Result;

class NewsTest extends PushTextReturnTestCase
{
    public function testPushTextReturnNews()
    {
        $output = $this->getOutput();

        $this->assertInstanceOf('SimpleXMLElement', $output);
        $this->assertEquals('fromUser', $output->FromUserName);
        $this->assertEquals('toUser', $output->ToUserName);
        $this->assertEquals('123456789', $output->CreateTime);
        $this->assertEquals('0', $output->FuncFlag);
        $this->assertEquals('2', $output->ArticleCount);
        $this->assertEquals('test item 1', $output->Articles->item->Title);
        $this->assertEquals('test item 1', $output->Articles->item->Description);
        $this->assertEquals('test item 1 pic url', $output->Articles->item->PicUrl);
        $this->assertEquals('test item 1 url', $output->Articles->item->Url);
        $this->assertEquals('test item 2', $output->Articles->item[1]->Title);
        $this->assertEquals('test item 2', $output->Articles->item[1]->Description);
        $this->assertEquals('test item 2 pic url', $output->Articles->item[1]->PicUrl);
        $this->assertEquals('test item 2 url', $output->Articles->item[1]->Url);
    }

    public function onPush($event)
    {
        $message = new Message();
        $message
            ->setType(Message::TYPE_NEWS)
            ->setFromUserName('fromUser')
            ->setToUserName('toUser')
            ->setCreateTime('123456789')
            ->setFuncFlag(0)
            ->addNewsItem(
                'test item 1',
                'test item 1',
                'test item 1 pic url',
                'test item 1 url')
            ->addNewsItem(
                'test item 2',
                'test item 2',
                'test item 2 pic url',
                'test item 2 url');
        $result = new Result();
        $result->setMessage($message);
        return $result;
    }
}
