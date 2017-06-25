<?php

namespace Lvphp\LvWeixin\Message;

use Lvphp\LvWeixin\Contract\MassMessage;
use Lvphp\LvWeixin\Contract\ReplyMessage;
use Lvphp\LvWeixin\Contract\SendMessage;

/**
 * 图片消息
 */
class Image implements ReplyMessage, SendMessage, MassMessage
{
    protected $type = 'image';
    protected $mediaId;

    public function __construct($mediaId)
    {
        $this->mediaId = $mediaId;
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
    public function xmlData()
    {
        return array(
            'Image' => array(
                'MediaId' => $this->mediaId,
            ));
    }

    /**
     * @return array
     */
    public function jsonData()
    {
        return array(
            'image' => array(
                'media_id' => $this->mediaId,
            ));
    }
}