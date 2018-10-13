<?php
namespace App\Api\RequestAPI;

use App\Proxy;

class RequestAPIPdo
{
    protected $pdo = null;

    public function getPDO()
    {
        if (is_null($this->pdo)) {
            $this->pdo =Proxy::init()->initDoctrine()->getConnecton();
//            $this->pdo = \DB::get();
        }
        return $this->pdo;
    }
}
