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

interface MessageInterface
{
    public function exchangeArray(Array $array);
    public function exchangeXml(SimpleXMLElement $xml);
}
