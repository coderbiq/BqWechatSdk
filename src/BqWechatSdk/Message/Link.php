<?php
namespace BqWechatSdk\Message;

use SimpleXMLElement;
use BqWechatSdk\Message;

class Link extends AbstractMessage
{
    public function exchangeXml(SimpleXMLElement $xml)
    {
        parent::exchangeXml($xml);
        $this
            ->setData('msg_id', $xml->MsgId)
            ->setData('title', $xml->Title)
            ->setData('description', $xml->Description)
            ->setData('url', $xml->Url);
    }

    public function getType()
    {
        return Message::TYPE_LINK;
    }

    public function getMsgId()
    {
        return $this->getData('msg_id');
    }

    public function getTitle()
    {
        return $this->getData('title');
    }

    public function getDescription()
    {
        return $this->getData('description');
    }

    public function getUrl()
    {
        return $this->getData('url');
    }
}
