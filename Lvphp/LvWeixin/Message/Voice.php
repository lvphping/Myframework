<?php

namespace Lvphp\LvWeixin\Message;

use Lvphp\LvWeixin\Contract\MassMessage;
use Lvphp\LvWeixin\Contract\SendMessage;
use Lvphp\LvWeixin\Contract\ReplyMessage;

/**
 * 语音消息
 */
class Voice implements ReplyMessage, SendMessage, MassMessage
{
    protected $type = 'voice';
    protected $attributes;

    public function __construct($mediaId)
    {
        $this->attributes = array(
            'mediaId' => $mediaId,
        );
    }

    /**
     * @return array
     */
    public function xmlData()
    {
        return array('Voice' => array(
            'MediaId' => $this->attributes['mediaId']
        ));
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function jsonData()
    {
        return array('voice' => array(
            'media_id' => $this->attributes['mediaId'],
        ));
    }

}