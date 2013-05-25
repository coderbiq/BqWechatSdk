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

class Location extends AbstractMessage
{
    public function exchangeXml(SimpleXMLElement $xml)
    {
        parent::exchangeXml($xml);
        $this
            ->setData('msg_id', $xml->MsgId)
            ->setData('lat', $xml->Location_X)
            ->setData('lon', $xml->Location_Y)
            ->setData('scale', $xml->Scale)
            ->setData('label', $xml->Label);
    }

    public function getType()
    {
        return Message::TYPE_LOCATION;
    }

    public function getMsgId()
    {
        return $this->getData('msg_id');
    }

    public function getLat()
    {
        return $this->getData('lat');
    }

    public function getLon()
    {
        return $this->getData('lon');
    }

    public function getScale()
    {
        return $this->getData('scale');
    }

    public function getLabel()
    {
        return $this->getData('label');
    }
}
