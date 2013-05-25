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

class Image extends AbstractMessage
{
    public function exchangeXml(SimpleXMLElement $xml)
    {
        parent::exchangeXml($xml);
        $this
            ->setData('msg_id', $xml->MsgId)
            ->setData('pic_url', $xml->PicUrl);
    }

    public function getType()
    {
        return Message::TYPE_IMAGE;
    }

    public function getMsgId()
    {
        return $this->getData('msg_id');
    }

    public function getPicUrl()
    {
        return $this->getData('pic_url');
    }

}
