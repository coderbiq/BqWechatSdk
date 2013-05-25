<?php
namespace BqWechatSdk\Message;

use BqWechatSdk\Message;

class Event extends AbstractMessage
{
    const EVENT_TYPE_SUBSCRIBE   = 'subscribe';
    const EVENT_TYPE_UNSUBSCRIBE = 'unsubscribe';
    const EVENT_TYPE_CLICK       = 'CLICK';

    public function getType()
    {
        return Message::TYPE_EVENT;
    }

    public function isSubscribeEvent()
    {
        return $this->getEvent() == self::EVENT_TYPE_SUBSCRIBE;
    }

    public function isUnsubscribeEvent()
    {
        return $this->getEvent() == self::EVENT_TYPE_UNSUBSCRIBE;
    }

    public function isClickEvent()
    {
        return $this->getEvent() == self::EVENT_TYPE_CLICK;
    }

    public function getEvent()
    {
        return $this->postData->Event;
    }

    public function getEventKey()
    {
        return $this->postData->EventKey;
    }
}
