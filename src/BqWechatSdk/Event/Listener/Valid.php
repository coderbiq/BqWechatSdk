<?php
namespace BqWechatSdk\Event\Listener;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use BqWechatSdk\Event\Push;
use BqWechatSdk\Event\Result;

class Valid implements ListenerAggregateInterface
{
    protected $listeners = array();
    protected $token;

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function attach(EventManagerInterface $events) {
        $this->listeners[] = $events
            ->attach(Push::EVENT_VALID, array($this, 'doValid'));
    }

    public function doValid($event)
    {
        $echostr   = $event->getParam('echostr');
        $timestamp = $event->getParam('timestamp');
        $nonce     = $event->getParam('nonce');
        $signature = $event->getParam('signature');

        $signatureTrue = array($this->token, $timestamp, $nonce);
        sort($signatureTrue);
        $signatureTrue = implode($signatureTrue);
        $signatureTrue = sha1($signatureTrue);

        if($signatureTrue == $signature) {
            return new Result($echostr);
        }
    }

    public function detach(EventManagerInterface $events) {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
}
