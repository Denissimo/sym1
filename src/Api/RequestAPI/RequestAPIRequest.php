<?php
namespace App\Api\RequestAPI;

class RequestAPIRequest
{
    private $requestFields = array(
        'surname',
        'name',
        'patronymic',
        'sex',
        'mobile',
        'email',
        'birthdate',
        'passport_id',
        'residence',
        'residence_fias',
        'amount',
        'term'
    );
    
    private $linkedFields = array(
        'residence' => 'residence_fias',
    );
    
    private $exceptionFields = array(
        'residence_fias',
    );

    private $data;
    private $signature;
    private $partner;
    private $foreign_id;
    private $check;
    private $ip;

    public function __construct($request)
    {
        $r = json_decode($request, true);
        if (empty($r) || !isset($r['data']) || !is_array($r['data']) || !isset($r['signature'])) {
            throw new \Exception('bad data');
        }
        $this->data = $r['data'];
        $this->signature = $r['signature'];
        $this->partner = isset($r['partner']) ? $r['partner'] : 0;
        $this->foreign_id = isset($r['foreign_id']) ? $r['foreign_id'] : 0;
        $this->check = isset($r['check']) ? $r['check'] : null;
        $this->ip = isset($r['ip']) ? $r['ip'] : 0;

        return true;
    }

    public function getProperty($param)
    {
        return isset($this->data[$param]) ? trim($this->data[$param]) : null;
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getPartner(){
        return $this->partner;
    }
    
    public function getForeignId(){
        return $this->foreign_id;
    }
    
    public function getCheck(){
        return $this->check;
    }
    
    public function getIp(){
        return $this->ip;
    }

    public function getRequestFields()
    {
        return $this->requestFields;
    }
    
    public function getLinkedField($field)
    {
        return isset($this->linkedFields[$field]) ? $this->linkedFields[$field] : null;
    }
    
    public function isExceptionField($field)
    {
        return in_array($field, $this->exceptionFields);
    }
}
