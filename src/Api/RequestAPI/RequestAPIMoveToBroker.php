<?php
namespace App\Api\RequestAPI;

use App\Api\Config;

class RequestAPIMoveToBroker extends RequestAPIPdo
{
    private $brokerId;

    public function __construct()
    {
        $this->brokerId = Config::get('requestAPI.defaultBrokerId');
    }

    public function move($persons, $comment = 'API')
    {
        $query = 'SELECT COUNT(id) c FROM person WHERE partner_id = ? AND id IN ('
                . implode(',', array_fill(0, count($persons), '?')) . ')';
        $sth = $this->getPDO()->prepare($query);
        $sth->execute(array_merge(array($this->brokerId), $persons));
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        if ($result['c'] > 0) {
            throw new RequestAPIException(RequestAPIResponseCode::BAD_PERSON_BROKER);
        }
        $partner = \Partners::getRepository('Partners')->find($this->brokerId);

        foreach ($persons as $pid) {
            $person = \Person::getRepository('Person')->find($pid);
            $p2b = \Person2Broker::transfer($person);
            $p2b->transferTo($partner);
            $p2b->setComment($comment);
            \CEntityManager::getInstance()->persist($p2b);
            \CEntityManager::getInstance()->flush();
        }
    }
}
