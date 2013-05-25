<?php
namespace BqWechatSdk\Message;

use SimpleXMLElement;
use BqWechatSdk\Message;

class Text extends AbstractMessage implements OutputMessageInterface
{
    public function exchangeXml(SimpleXMLElement $xml)
    {
        parent::exchangeXml($xml);
        $this
            ->setData('msg_id', $xml->MsgId)
            ->setContent($xml->Content);
    }

    public function getType()
    {
        return Message::TYPE_TEXT;
    }

    public function getMsgId()
    {
        return $this->getData('msg_id');
    }

    public function getContent()
    {
        return $this->getData('content');
    }

    public function setContent($content)
    {
        return $this->setData('content', $content);
    }

    public function toXmlString()
    {
        $xml = "
            <xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%d</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>%d</FuncFlag>
            </xml>
            ";

        return sprintf(
            $xml, 
            $this->getToUserName(), 
            $this->getFromUserName(),
            $this->getCreateTime(),
            $this->getContent(),
            $this->getFuncFlag()
        );

    }
}
