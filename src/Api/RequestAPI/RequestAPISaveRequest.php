<?php
namespace App\Api\RequestAPI;

class RequestAPISaveRequest extends RequestAPIPdo
{
    /** @var  requestAPIRequest */
    private $request;
    private $id;

    /**
     * @param requestAPIRequest $request
     */
    public function setRequest(requestAPIRequest $request)
    {
         $this->request = $request;
    }

    public function save()
    {
        $requestFields = $this->request->getRequestFields();
        $fields = array();
        $values = array();
        foreach ($requestFields as $value) {
            $fields[$value] = $value . ' = :' . $value;
            $values[$value] = $this->request->getProperty($value);
        }

        $fields['partner'] = 'partner = :partner';
        $values['partner'] = $this->request->getPartner();

        $query = 'INSERT INTO request_api SET create_ts = NOW(), ' . implode(', ', $fields);
        $sth = $this->getPDO()->prepare($query);
        $sth->execute($values);
        $this->id = $this->getPDO()->lastInsertId();
        return $this->id;

    }

    public function savePid($pid)
    {
        $query = 'UPDATE request_api SET pid = :pid WHERE id = :id';
        $sth = $this->getPDO()->prepare($query);
        $sth->execute(array('pid' => $pid, 'id' => $this->id));
    }

    public function saveDecision($decision)
    {
        $query = 'UPDATE request_api SET decision = :decision WHERE id = :id';
        $sth = $this->getPDO()->prepare($query);
        $sth->execute(array('decision' => $decision, 'id' => $this->id));
    }
}
