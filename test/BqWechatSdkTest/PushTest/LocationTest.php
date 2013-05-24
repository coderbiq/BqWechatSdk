<?php
namespace BqWechatSdkTest\PushTest;

class LocationTest extends AbstractPush
{
    public function getPushXml()
    {
        $xml = "
            <xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%d</CreateTime>
                <MsgType><![CDATA[location]]></MsgType>
                <Location_X>23.134521</Location_X>
                <Location_Y>113.358803</Location_Y>
                <Scale>20</Scale>
                <Label><![CDATA[位置信息]]></Label>
                <MsgId>1234567890123456</MsgId>
            </xml> 
            ";

        $xml = sprintf(
            $xml, 
            $this->getToUserName(), 
            $this->getFromUserName(), 
            $this->getCreateTime());

        return $xml;
    }

    public function onPush($event)
    {
        parent::onPush($event);

        $message = $event->getMessage();
        $this->assertTrue($message->isLocation());
        $this->assertEquals('23.134521', $message->getLat());
        $this->assertEquals('113.358803', $message->getLon());
        $this->assertEquals('20', $message->getScale());
        $this->assertEquals('位置信息', $message->getLabel());
        $this->assertEquals('1234567890123456', $message->getMsgId());
    }
}
