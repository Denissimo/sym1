<?php
namespace App\Api\RequestAPI;

use App\Api\Config;

class RequestAPISearchSimilar extends RequestAPIPdo
{

    private $request;
    private $requestLifeTimeHour;

    public function __construct(requestAPIRequest $request)
    {
        $this->request = $request;
        $this->requestLifeTimeHour = Config::get('requestAPI.requestLifeTimeHour');
    }

    public function search()
    {
        $this->searchRequestPassport();
        $this->searchRequestEmail();
        $this->searchRequestMobile();

        return true;
    }

    private function searchRequest($param)
    {
        $value = $this->request->getProperty($param);
        if (empty($value)) {
            return true;
        }
        $query = "select id from request_api where create_ts > now() - interval :hour hour and {$param} = :param";
        $sth = $this->getPDO()->prepare($query);
        $sth->execute(array('hour' => $this->requestLifeTimeHour, 'param' => $value));
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        if (isset($result['id'])) {
            throw new RequestAPIException(RequestAPIResponseCode::DUPLICATE_REQUEST);
        }

        return true;
    }

    private function searchRequestPassport()
    {
        return $this->searchRequest('passport_id');
    }

    private function searchRequestEmail()
    {
        return $this->searchRequest('email');
    }

    private function searchRequestMobile()
    {
        return $this->searchRequest('mobile');
    }

}
