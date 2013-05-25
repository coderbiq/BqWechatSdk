<?php
/**
 * BqWechatSdk (https://github.com/elvis-bi/BqWechatSdk)
 *
 * @link https://github.com/elvis-bi/BqWechatSdk for this canonical source repository
 * @copyright elvis bi (elvis@dwenzi.com)
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

namespace BqWechatSdk;

use Zend\EventManager\EventManager;
use BqWechatSdk\Event\Result as EventResult;
use BqWechatSdk\Event\Push as PushEvent;

/**
 * 类Listener监听来自微信的网址接入验证和消息推送
 *
 * 使用的时候先要向Listener设置一个EventManager对象，当收到请求时Listener将通过
 * EventManager进行事件的广播。
 *
 * <code>
 * $eventManager = new EventManager();
 * # 绑定监听
 * $eventManager->attach({事件名},{回调函数});
 *
 * $listener = new Listener();
 * $listener->setEventManager($eventManager)->run();
 * </code>
 */
class Listener
{
    protected $eventManager;

    public function setEventManager(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
        return $this;
    }

    public function run()
    {
        if(isset($_GET['echostr'])) {
            $results = $this->triggerValidEvent();
        } else {
            $results = $this->triggerPushEvent();
        }

        $result = $results->last();
        if($result instanceof EventResult) {
            echo $result->output();
        }
    }

    protected function triggerValidEvent()
    {
        $event = new PushEvent();
        $event
            ->setName(PushEvent::EVENT_VALID)
            ->setParam('echostr', $_GET['echostr'])
            ->setParam('timestamp', $_GET['timestamp'])
            ->setParam('nonce', $_GET['nonce'])
            ->setParam('signature', $_GET['signature']);
        return $this->eventManager->trigger($event);
    }

    protected function triggerPushEvent()
    {
        $event = new PushEvent();
        $event->setName(PushEvent::EVENT_PUSH);

        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)) {
            $postObj = simplexml_load_string(
                $postStr, 
                'SimpleXMLElement', 
                LIBXML_NOCDATA);
            $message = new Message();
            $message->exchangeXml($postObj);
            $event->setMessage($message);
        }

        return $this->eventManager->trigger($event);
    }
}
