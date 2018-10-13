<?php
namespace App\Api\RequestAPI;

class RequestAPIPartner extends RequestAPIPdo
{
    private $id;
    private $name;
    private $key;

    public function __construct($id)
    {
        $query = 'SELECT * FROM request_api_partner WHERE id = :id';
        $sth = $this->getPDO()->prepare($query);
        $sth->execute(array('id' => $id));
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        if (!isset($result['id']) || $result['is_enabled'] == 0) {
            throw new RequestAPIException(RequestAPIResponseCode::BAD_PARTNER);
        }
        $this->id = $id;
        $this->name = $result['name'];
        $this->key = $result['key'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getKey()
    {
        return $this->key;
    }
}
