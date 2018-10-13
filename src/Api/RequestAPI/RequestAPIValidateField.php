<?php
namespace App\Api\RequestAPI;

class RequestAPIValidateField
{
    protected $field;
    protected $fieldName;
    protected $regExp;
    protected $mandatory;

    public function validate()
    {
        if (empty($this->field) && !$this->mandatory) {
            return true;
        }

        if (empty($this->field) || (!empty($this->regExp) && !preg_match("/^" . $this->regExp . "$/iu", $this->field))) {
            $constName = '\RequestAPI\RequestAPIResponseCode::BAD_FIELD_' . strtoupper($this->fieldName);
            if (defined($constName)) {
                $code = constant($constName);
            } else {
                $code = RequestAPIResponseCode::BAD_FIELD;
            }
            throw new RequestAPIException($code);
        }

        return true;
    }

    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;
        return $this;
    }

    public function setRegExp($regExp)
    {
        $this->regExp = $regExp;
        return $this;
    }

    public function setMandatory($mandatory)
    {
        $this->mandatory = $mandatory;
        return $this;
    }
}
