<?php
namespace App\Api\RequestAPI;

class RequestAPICheckBlackList extends RequestAPIPdo
{
    const TYPE_PHONE = 1;
    const TYPE_PASSPORT = 2;

    private $request;

    public function __construct(requestAPIRequest $request) {
        $this->request = $request;
    }

    public function check()
    {
        $this->checkPhone();
        $this->checkPassport();
    }

    private function checkPhone()
    {
        $phone = preg_replace('/\D/', '', $this->request->getProperty('mobile'));
        $phone = preg_replace('/^7/', '', $phone);
        $this->checkBlackList(self::TYPE_PHONE, $phone);
    }

    private function checkPassport()
    {
        $passport = $this->request->getProperty('passport_id');
        $this->checkBlackList(self::TYPE_PASSPORT, $passport);
    }

    private function checkBlackList($type, $val)
    {
        $query = "SELECT COUNT(id) c FROM blacklist WHERE type = :type AND val = :val;";
        $sth = $this->getPDO()->prepare($query);
        $sth->execute(array('type' => $type, 'val' => $val));
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        if ($result['c'] > 0) {
            throw new RequestAPIException(RequestAPIResponseCode::BAD_PERSON_BLACKLIST);
        }
    }

}
