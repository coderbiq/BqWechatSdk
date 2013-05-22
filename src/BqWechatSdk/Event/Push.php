<?php
namespace BqWechatSdk\Event;

use Zend\EventManager\Event;

class Push extends Event
{
    const EVENT_VALID = 'BqWechatSdk.event.push.valid';
}
