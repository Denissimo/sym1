<?php
namespace App\Api\RequestAPI;

class RequestAPI
{
    const DECISION_SUCCESS_BROKER = 1;
    const DECISION_SUCCESS_NEW_PERSON = 2;

    private $request;
    private $partner;
    private $response;
    private $errorCode;
    private $error;
    private $continueLink;
    /** @var  RequestAPISaveRequest */
    private $saveRequest;

    public function __construct($request)
    {
        try {
            $this->outOfService();
            $this->requestLimit();
            $this->request = new RequestAPIRequest($request);
            $this->partner = new RequestAPIPartner($this->request->getPartner());
            $this->validateSignature();
            $this->validateRequest();
            $this->searchSimilar();
            $this->saveRequest();
            //$this->checkBlackList();
            //$persons = $this->searchPerson();
            //$persons = array();
            //$newPerson = false;
            $this->updateRequest($this->addPerson());
            $this->updateDecision(self::DECISION_SUCCESS_NEW_PERSON);
            $this->response = 'new person added';

        } catch (RequestAPIException $e) {
            $this->errorCode = $e->getCode();
            $this->error = $e->getMessage();
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }

        $this->response();
    }

    public function getRequest()
    {
        return $this->request;
    }

    private function validateSignature()
    {
        $signature = new RequestAPISignature($this->request, $this->partner);
        $signature->validateSignature();
    }

    private function validateRequest()
    {
        $validate = new RequestAPIValidate($this->request);
        $validate->validate();
    }

    private function searchSimilar()
    {
        $searchSimilar = new RequestAPISearchSimilar($this->request);
        $searchSimilar->search();
    }

    private function searchPerson()
    {
        $searchPerson = new RequestAPISearchPerson($this->request);
        return $searchPerson->search();
    }

    private function checkBlackList()
    {
        $checkBlackList = new RequestAPICheckBlackList($this->request);
        $checkBlackList->check();
    }

    private function saveRequest()
    {
        $this->saveRequest = new RequestAPISaveRequest();
        $this->saveRequest->setRequest($this->request);
        $this->saveRequest->save();
    }

    private function updateRequest($pid)
    {
        $this->saveRequest->savePid($pid);
    }

    private function updateDecision($decision)
    {
        $this->saveRequest->saveDecision($decision);
    }

    private function addPerson()
    {
        $addPerson = new RequestAPIAddPerson($this->request);
        return $addPerson->add();
    }

    private function moveToBroker($persons, $newPerson = false) {
        $moveToBroker = new RequestAPIMoveToBroker();
        $moveToBroker->move($persons, 'API ' . $this->partner->getName());
        $this->response = $newPerson ? 'new person added' : 'moved to broker';
    }

    private function outOfService()
    {
        $outOfSerice = new RequestAPICheckWorkingTime();
        $outOfSerice->check();
    }

    private function requestLimit()
    {
        $requestLimit = new RequestAPIRequestLimit();
        $requestLimit->check();
    }

    private function response()
    {
        $response = array();
        if (!empty($this->errorCode)) {
            $response['errorcode'] = $this->errorCode;
        }
        if (!empty($this->error)) {
            $response['error'] = $this->error;
        }
        if (!empty($this->response)) {
            $response['response'] = $this->response;
        }
        if (!empty($this->continueLink)) {
            $response['link'] = $this->continueLink;
        }
        echo json_encode($response);
    }

}
