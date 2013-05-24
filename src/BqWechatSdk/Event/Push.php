<?php
namespace BqWechatSdk\Event;

use Zend\EventManager\Event;

class Push extends Event
{
    const EVENT_VALID = 'BqWechatSdk.event.push.valid';
    const EVENT_PUSH  = 'BqWechatSdk.event.push.push';

    protected $message;

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}
