<?php
namespace App\Api\RequestAPI;

use App\Api\Config;

class RequestAPIValidateBirthdate extends RequestAPIValidateField
{
    private $minAge;

    public function __construct()
    {
        $this->minAge = Config::get('requestAPI.minAge');
    }

    public function validate() {
        parent::validate();

        if (!empty($this->field) && $this->mandatory) {
            $birthday = new \DateTime($this->field);
            $now = new \DateTime();
            $age = $now->diff($birthday);

            if ($birthday->format('Y') > $now->format('Y') || $age->y < $this->minAge) {
                throw new RequestAPIException(RequestAPIResponseCode::BAD_FIELD_BIRTHDATE);
            }
        }

        return true;
    }

}
