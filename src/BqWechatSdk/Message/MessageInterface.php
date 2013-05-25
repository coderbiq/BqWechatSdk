<?php
namespace BqWechatSdk\Message;

use SimpleXMLElement;

interface MessageInterface
{
    public function exchangeArray(Array $array);
    public function exchangeXml(SimpleXMLElement $xml);
#    public function toXmlString();
}
