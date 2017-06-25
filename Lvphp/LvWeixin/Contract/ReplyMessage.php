<?php

namespace Lvphp\LvWeixin\Contract;

interface ReplyMessage extends Message
{
    /**
     * @return array
     */
    public function xmlData();
}