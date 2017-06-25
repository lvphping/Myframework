<?php

namespace Lvphp\LvWeixin\SDK\Redpack;

class  SDKRuntimeException extends \Exception
{
    public function errorMessage()
    {
        return $this->getMessage();
    }

}

