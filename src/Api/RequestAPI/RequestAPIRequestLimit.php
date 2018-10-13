<?php
namespace App\Api\RequestAPI;

use App\Api\Config;

class RequestAPIRequestLimit extends RequestAPIPdo
{
    private $requestLimit;

    public function __construct()
    {
        $this->requestLimit = Config::get('requestAPI.requestLimit');
    }

    public function check()
    {
        $query = 'SELECT COUNT(id) c FROM request_api WHERE decision > 0 '
                . 'AND create_ts > CURDATE()';
        $sth = $this->getPDO()->prepare($query);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        if ($result['c'] >= $this->requestLimit) {
            throw new RequestAPIException(RequestAPIResponseCode::REQUEST_LIMIT);
        }
    }
}
