<?php
namespace App\Api\RequestAPI;

use App\Api\Config;
//use ChSlovo\Common\Config;

class RequestAPISearchPerson extends RequestAPIPdo
{

    private $request;
    private $passportFid;
    private $failureStatuses;
    private $personFailureDay;

    public function __construct(requestAPIRequest $request) {
        $this->request = $request;
	$this->passportFid = Config::get('requestAPI.passportFid');
        $this->failureStatuses = Config::get('requestAPI.failureStatuses');
        $this->personFailureDay = Config::get('requestAPI.personFailureDay');
    }

    public function search()
    {
        $this->checkPassportByPersons();
        return $this->checkLoansStatusByPersons();
    }

    private function serchPersonsByPhone()
    {
        $query = 'SELECT pid FROM person_phone WHERE phone = :phone';
        $sth = $this->getPDO()->prepare($query);
        $sth->execute(array('phone' => $this->request->getProperty('mobile')));
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(function ($el) {return $el['pid'];}, $result);
    }

    private function searchPersonsByPassport()
    {
        $query = 'SELECT pid FROM formfieldsvalue WHERE fid = :fid AND val = :val';
        $sth = $this->getPDO()->prepare($query);
        $sth->execute(array('fid' => $this->passportFid,
            'val' => $this->request->getProperty('passport_id')));
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(function ($el) {return $el['pid'];}, $result);
    }

    private function checkLoansStatusByPersons()
    {
        $persons = $this->searchPersonsByPassport();

        if (!empty($persons)) {
            $query = 'SELECT COUNT(DISTINCT request_id) c FROM credit WHERE pid '
                    . 'IN (' . implode(',', $persons) . ') AND (status IN ('
                    . \Credit::getGroupIN(\Credit::G_ISSUED) . ')  OR '
                    . '(status = :statusFailure AND status_comment_id IN ('
                    . $this->failureStatuses . ')) '
                    . 'OR (status = :statusFailure AND create_ts > NOW() - interval :day day))';
            $sth = $this->getPDO()->prepare($query);
            $sth->execute(array('statusFailure' => \Credit::FAILURE, 'day' => $this->personFailureDay));
            $result = $sth->fetch(\PDO::FETCH_ASSOC);
            if ($result['c'] > 0) {
                throw new RequestAPIException(RequestAPIResponseCode::BAD_PERSON_PASSPORT);
            }
        }

        return $persons;
    }

    private function checkPassportByPersons()
    {
        $persons = $this->serchPersonsByPhone();

        if (!empty($persons)) {
            $query = 'SELECT COUNT(pid) c FROM formfieldsvalue WHERE fid = :fid AND '
                    . 'val != :val AND pid IN (' . implode(',', $persons) . ')';
            $sth = $this->getPDO()->prepare($query);
            $sth->execute(array('fid' => $this->passportFid,
                'val' => $this->request->getProperty('passport_id')));
            $result = $sth->fetch(\PDO::FETCH_ASSOC);
            if ($result['c'] > 0) {
                throw new RequestAPIException(RequestAPIResponseCode::BAD_PERSON_PHONE);
            }
        }
    }
}
