<?php
namespace App\Api\RequestAPI;

class RequestAPIException extends \Exception
{
    public function __construct($code, $message = '')
    {
        if (empty($message)) {
            $message = RequestAPIResponseCode::getCodeDescription($code);
        }
        parent::__construct($message, $code);
    }
}
