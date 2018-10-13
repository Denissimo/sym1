<?php
namespace App\Api\RequestAPI;

class RequestAPISignature
{

    private $password;
    private $request;

    public function __construct(RequestAPIRequest $request, RequestAPIPartner $partner)
    {
        $this->request = $request;
        $this->password = $partner->getKey();

        return $this;
    }

    public function validateSignature()
    {
        if ($this->request->getSignature() != $this->getSignature()) {
            throw new RequestAPIException(RequestAPIResponseCode::BAD_SIGNATURE);
        }
        return true;
    }

    private function getSignature()
    {
        return base64_encode(sha1(json_encode($this->request->getData()) . $this->password, true));
    }
}
