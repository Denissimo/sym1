<?php
namespace App\Api\RequestAPI;

use App\Api\Config;

class RequestAPIValidate
{
    private $request;

    public function __construct(requestAPIRequest $request)
    {
        $this->request = $request;
    }

    public function validate()
    {
        $requestFields = $this->request->getRequestFields();
        foreach ($requestFields as $value) {
            if ($value == 'birthdate') {
                $field = new RequestAPIValidateBirthdate();
            } else {
                $field = new RequestAPIValidateField();
            }
            $field->setField($this->request->getProperty($value))
                    ->setFieldName($value)
                    ->setRegExp(Config::get('requestAPI.reqExp.' . $value))
                    ->setMandatory(Config::get('requestAPI.mandatory.' . $value))
                    ->validate();
        }
    }
}
