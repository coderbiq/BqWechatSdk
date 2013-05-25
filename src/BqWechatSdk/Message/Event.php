<?php
/**
 * BqWechatSdk (https://github.com/elvis-bi/BqWechatSdk)
 *
 * @link https://github.com/elvis-bi/BqWechatSdk for this canonical source repository
 * @copyright elvis bi (elvis@dwenzi.com)
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

namespace BqWechatSdk\Message;

use SimpleXMLElement;
use BqWechatSdk\Message;

class Event extends AbstractMessage
{
    const EVENT_TYPE_SUBSCRIBE   = 'subscribe';
    const EVENT_TYPE_UNSUBSCRIBE = 'unsubscribe';
    const EVENT_TYPE_CLICK       = 'CLICK';

    public function exchangeXml(SimpleXMLElement $xml)
    {
        parent::exchangeXml($xml);
        $this
            ->setData('event', $xml->Event)
            ->setData('event_key', $xml->EventKey);
    }

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
        return $this->getData('event');
    }

    public function getEventKey()
    {
        return $this->getData('event_key');
    }
}
