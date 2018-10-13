<?php

namespace App\Api\Leadgid;

use App\Proxy;

class Leadgid
{
    private $url;
    private $affiliateId;
    private $apiKey;
    private $userId;
    private $data;

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function setAffiliateId($affiliate_id)
    {
        $this->affiliateId = $affiliate_id;
        return $this;
    }

    public function setApiKey($api_key)
    {
        $this->apiKey = $api_key;
        return $this;
    }

    private function sendRequest()
    {
        $auth['affiliate_id'] = $this->affiliateId;
        $auth['api_key'] = $this->apiKey;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url . '?' . http_build_query($auth));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_HEADER, 1);

        $response = curl_exec($ch);
        curl_close($ch);

        $this->log($response);

        //echo $response;


    }

    private function log($response)
    {
        $query = "insert into app_log set app_id = :app_id, channel_id = :channel_id, ts = now(), status = :status, success = :success, message = :message ";
        $r = json_decode($response, true);
        $this->data = array('app_id' => $this->userId, 'channel_id' => 3, 'status' => 1, 'success' => (!isset($r['errors']) ? 1 : 0), 'message' => $response);
        $sth = Proxy::init()->initDoctrine()->getConnecton()->prepare($query);
//		$sth = DB::get()->prepare($query);
        $sth->execute($this->data);
    }


    private function convertIncome($param)
    {
        $income = array(
            43 => 20000,
            44 => 30000,
            45 => 50000,
            46 => 70000,
            47 => 100000,
            48 => 120000,
        );
        $result = isset($income[$param]) ? $income[$param] : '';

        return $result;
    }

    private function clearPhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $phone = preg_replace('/^7/', '', $phone);
        return $phone;
    }

    private function convertRegion($id)
    {
        $regions = array(104 => 22, 105 => 28, 106 => 29, 107 => 30, 108 => 31, 109 => 32, 110 => 33, 111 => 34, 112 => 35, 113 => 36, 114 => 77, 115 => 79, 116 => 75, 117 => 37, 118 => 99, 119 => 38, 120 => 07, 121 => 39, 122 => 40, 123 => 41,
            124 => 9, 125 => 42, 126 => 43, 127 => 44, 128 => 23, 129 => 24, 130 => 45, 131 => 46, 132 => 47, 133 => 48, 134 => 49, 135 => 50, 136 => 51, 137 => 83, 138 => 52, 139 => 53, 140 => 54, 141 => 55, 142 => 56, 143 => 57, 144 => 58, 145 => 59, 146 => 25, 147 => 60, 148 => 01, 149 => 04, 150 => 02, 151 => 03, 152 => 05, 153 => 06, 154 => 8, 155 => 10, 156 => 11, 157 => 91, 158 => 12, 159 => 13, 160 => 14, 161 => 15, 162 => 16, 163 => 17, 164 => 19, 165 => 61, 166 => 62, 167 => 63, 168 => 78, 169 => 64, 170 => 65, 171 => 66, 172 => 92, 173 => 67, 174 => 26, 175 => 68, 176 => 69, 177 => 70, 178 => 71, 179 => 72, 180 => 18, 181 => 73, 182 => 27, 183 => 86, 184 => 74, 185 => 20, 186 => 21, 187 => 87, 188 => 89, 189 => 76);

        $regionsLeadgidId = array('01' => 1, '04' => 2, '22' => 3, '28' => 4, '29' => 5, '30' => 6, '99' => 7, '02' => 8, '31' => 9, '32' => 10, '03' => 11, '33' => 12, '34' => 13, '35' => 14, '36' => 15, '05' => 16, '79' => 17, '75' => 18, '37' => 19, '06' => 20, '38' => 21, '07' => 22, '39' => 23, '08' => 24, '40' => 25, '41' => 26, '09' => 27, '10' => 28, '42' => 29, '43' => 30, '11' => 31, '44' => 32, '23' => 33, '24' => 34, '91' => 35, '45' => 36, '46' => 37, '47' => 38, '48' => 39, '49' => 40, '12' => 41, '13' => 42, '77' => 43, '50' => 44, '51' => 45, '83' => 46, '52' => 47, '53' => 48, '54' => 49, '55' => 50, '56' => 51, '57' => 52, '58' => 53, '59' => 54, '25' => 55, '60' => 56, '61' => 57, '62' => 58, '63' => 59, '78' => 60, '64' => 61, '14' => 62, '65' => 63, '66' => 64, '92' => 65, '15' => 66, '67' => 67, '26' => 68, '68' => 69, '16' => 70, '69' => 71, '70' => 72, '71' => 73, '17' => 74, '72' => 75, '18' => 76, '73' => 77, '27' => 78, '19' => 79, '86' => 80, '74' => 81, '20' => 82, '21' => 83, '87' => 84, '89' => 85, '76' => 86);

        return $regionsLeadgidId[$regions[$id]];
    }


    public function send($id, $partner)
    {
        $this->userId = $id;

        $this->data = array();
        $this->data['subid1'] = $partner == 2 ? 'credito' : 'kz';
        $this->data['amount'] = Functions::getValueText($this->userId, 'creditAmount');
        $this->data['term'] = Functions::getValueText($this->userId, 'creditTerm');
        $this->data['last_name'] = Functions::getValueText($this->userId, 'secondName');
        $this->data['first_name'] = Functions::getValueText($this->userId, 'name');
        $this->data['middle_name'] = Functions::getValueText($this->userId, 'middleName');
        $this->data['gender'] = Functions::getValueTextId($this->userId, 'sex') == 1 ? 'male' : 'female';
        $this->data['birthdate'] = preg_replace('/(\d{2})\.(\d{2})\.(\d{4})/ims', '\\3-\\2-\\1', Functions::getValueText($this->userId, 'birthDate'));
        $this->data['birth_place'] = Functions::getValueText($this->userId, 'birthPlace');
        $this->data['email'] = Functions::getValueText($this->userId, 'email');
        $this->data['phone'] = $this->clearPhone(Functions::getValueText($this->userId, 'mobileNumber'));
        $this->data['region'] = $this->convertRegion(Functions::getValueTextId($this->userId, 'region'));
        $this->data['city'] = Functions::getValueText($this->userId, 'city');
        $this->data['zip_code'] = Functions::getValueText($this->userId, 'index');
        $this->data['street'] = Functions::getValueText($this->userId, 'street');

        $passport = preg_replace('/\D/', '', Functions::getValueText($this->userId, 'passportNumber'));

        $this->data['passport_series'] = substr($passport, 0, 4);
        $this->data['passport_number'] = substr($passport, 4, 6);
        $this->data['passport_issued_date'] = preg_replace('/(\d{2})\.(\d{2})\.(\d{4})/ims', '\\3-\\2-\\1', Functions::getValueText($this->userId, 'passportDate'));
        $this->data['passport_issued_by'] = Functions::getValueText($this->userId, 'passportWho');
        $this->data['passport_unit_code'] = Functions::getValueText($this->userId, 'passportCode');
        $this->data['residential_address_street_id'] = Functions::getValueText($this->userId, 'street1');
        $this->data['residential_address_house'] = Functions::getValueText($this->userId, 'house1');
        $this->data['residential_address_flat'] = '';
        $this->data['income'] = $this->convertIncome(Functions::getValueTextId($this->userId, 'income'));
        $this->data['income_other'] = '';
        $this->data['work_organization'] = Functions::getValueText($this->userId, 'company_name');
        $this->data['work_address'] = '';
        $this->data['work_occupation'] = '';
        $this->data['work_experience'] = '';
        $this->data['work_phone'] = $this->clearPhone(Functions::getValueText($this->userId, 'work_phone'));
        $this->data['work_chief'] = '';
        $this->data['credhistory_radio'] = '';
        $this->data['marital_status'] = '';
        $this->data['childrens'] = '';
        $this->data['confidant_name'] = '';
        $this->data['confidant_type'] = '';
        $this->data['confidant_phone'] = '';

        $this->sendRequest();

    }

}
