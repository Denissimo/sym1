<?php
namespace App\Api\RequestAPI;

use App\Api\Config;

class RequestAPIAddPerson extends RequestAPIPdo
{
    private $request;
    private $fieldsFid = array();

    public function __construct(requestAPIRequest $request) {
        $this->request = $request;
        $requestFields = $this->request->getRequestFields();
        foreach ($requestFields as $field) {
            if ($this->request->isExceptionField($field)) {
                continue;
            }
            $this->fieldsFid[$field] = Config::get('requestAPI.fid.' . $field);
        }

    }

    public function add()
    {
        $query = 'INSERT INTO apps SET partner_id = :partner, foreign_id = :foreign_id, user_id = :user_id, status = 0, createdAt = now(), updatedAt = now(), ip = INET_ATON(:ip), `check` = :check;';
        $sth = $this->getPDO()->prepare($query);
        $sth->bindValue(':partner', $this->request->getPartner(), \PDO::PARAM_INT);
        $sth->bindValue(':foreign_id', $this->request->getForeignId(), \PDO::PARAM_INT);
        $sth->bindValue(':user_id', 0, \PDO::PARAM_INT);
        $sth->bindValue(':ip', $this->request->getIp(), \PDO::PARAM_STR);
        $sth->bindValue(':check', $this->request->getCheck(), \PDO::PARAM_STR);
        $sth->execute();
        $this->pid = $this->getPDO()->lastInsertId();
        if (!empty($this->pid)) {
            $this->saveFields();
            $this->saveVersion();
        }

        return $this->pid;
    }
    
    private function saveFields()
    {
        $requestFields = $this->request->getRequestFields();
        foreach ($requestFields as $field) {
            if ($this->request->isExceptionField($field)) {
                continue;
            }
            $linkedField = $this->request->getLinkedField($field);
            if (!$this->request->getProperty($field)) {
                continue;
            }
            $params = array(
                'id' => $this->pid,
                'field_id' => $this->fieldsFid[$field],
                'value' => $this->request->getProperty($field)
            );
            if (empty($linkedField)) {
                $query = "INSERT INTO field_values SET app_id = :id, field_id = :field_id, value_text = :value";
            } else {
                $params['linked_field'] = $this->request->getProperty($linkedField);
                $query = "INSERT INTO field_values SET app_id = :id, field_id = :field_id, value_text = :value, value= :linked_field";
            }
            $sth = $this->getPDO()->prepare($query);
            $sth->execute($params);
            $arr = $sth->errorInfo();
        }
    }
    
    private function saveVersion()
    {
        $version = array('app' => null, 'field_values'=>null);
        
        $query = "SELECT * FROM apps where id = :id";
        $sth = $this->getPDO()->prepare($query);
        $sth->execute(array('id' => $this->pid));
        $_tmp1 = $sth->fetch(\PDO::FETCH_ASSOC);

        $query = "SELECT * FROM field_values where app_id = :id order by id asc";
        $sth = $this->getPDO()->prepare($query);
        $sth->execute(array('id' => $this->pid));
        $_tmp2 = $sth->fetchAll(\PDO::FETCH_ASSOC);
        
        $version['app'] = $_tmp1;
        $version['field_values'] = $_tmp2;

        $query = "INSERT IGNORE INTO apps_versions SET app_id = :app_id, ts=now(), uid = :uid, data = :version";
        $sth = $this->getPDO()->prepare($query);
        $sth->execute(array('app_id' => $this->pid, 'uid' => 0, 'version' => json_encode($version)));
    }
    
}
