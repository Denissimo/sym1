<?php

namespace App\Api\Slovo;

use App\Proxy;
use Cake\Database\Exception;
use Symfony\Component\HttpFoundation\Request;
use PDO;


class Api4s
{

    /**
     * @return \Doctrine\DBAL\Connection
     */
    private static function getDb()
    {
        return Proxy::init()->getEntityManager()->getConnection();
    }

    private function response($ok, $response)
    {
        $data['ok'] = $ok;
        if ($ok == 1) {
            $data['response'] = $response;
        } else {
            $data['response'] = $response;
        }

        echo json_encode($data);
        die();
    }

    private function checkFIAS($id, $field)
    {
        $value = Functions::getValueText2($id, $field);
        if (empty($value)) {
//            $this->response(0, $field . ' fias empty');
        }
        return $value;

    }

    public function dataSend(Request $request)
    {
        $id = intval($request->get('id'));
        $operator = intval($request->get('operator'));

        $query = 'select id from app_log where channel_id = :channel_id and app_id = :app_id limit 1;';
        $sth = self::getDb()->prepare($query);
        $sth->execute(array('channel_id' => 4, 'app_id' => $id));
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        if (isset($result['id'])) {
            $this->response(0, 'Already sent');
        }

        $query = "select partner_id, foreign_id, status, `check` from apps where id = :id;";
        $sth = self::getDb()->prepare($query);
        $sth->execute(array('id' => $id));
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            $this->response(0, 'Person not found');
        }
        /*
        if (empty($result['check'])) {
            $this->response(0, 'Empty check');
        }
        */
        if (empty($result['status'])) {
            $this->response(0, 'Status not ready');
        }

        try {

            $pass = 'H0XtlQkar3uigSwyjF_BIdm1v66-XqI2';
            $data['partner'] = $result['partner_id'];
            $data['pid'] = $result['foreign_id'];
            $data['check'] = $result['check'];
            $data['operator'] = $operator;

            $data['data']['amount'] = Functions::getValueText($id, 'creditAmount');
            $data['data']['term'] = Functions::getValueText($id, 'creditTerm');

            $data['data']['mobile'] = Functions::getValueText($id, 'mobileNumber');
            $data['data']['secondName'] = Functions::getValueText($id, 'secondName');
            $data['data']['name'] = Functions::getValueText($id, 'name');
            $data['data']['middleName'] = Functions::getValueText($id, 'middleName');
            $data['data']['sex'] = Functions::getValueText($id, 'sex');
            $data['data']['birthDate'] = date_create_from_format('d.m.Y', Functions::getValueText($id, 'birthDate'))->format('Y-m-d');
            $data['data']['birthPlace'] = Functions::getValueText($id, 'birthPlace');
            $data['data']['passportNumber'] = Functions::getValueText($id, 'passportNumber');
            $data['data']['passportWho'] = Functions::getValueText($id, 'passportWho');
            $data['data']['passportDate'] = Functions::getValueText($id, 'passportDate');
            $data['data']['passportCity'] = $this->checkFIAS($id, 'passportCity');
            $data['data']['passportCity'] = Functions::getValueText($id, 'passportCity');
            $data['data']['passportCode'] = Functions::getValueText($id, 'passportCode');

            $marital_statuses = array(
                84 => '42',
                85 => '41',
                86 => '40',
                87 => '44',
                88 => '43'
            );

//        $marital_status = Functions::getValueTextId($id, 'maritalStatus');
            $marital_status = Functions::getValueText($id, 'maritalStatus');
//        var_dump($marital_status); die;
            $data['data']['maritalStatus'] = $marital_statuses[$marital_status] ?? 0;
//        var_dump($data); die;
            $educations = array(
                89 => '26',
                90 => '27',
                91 => '61',
                92 => '62',
                93 => '63',
                94 => '64'
            );


//        $education = Functions::getValueTextId($id, 'education');
            $education = Functions::getValueText($id, 'education');
            $data['data']['education'] = $educations[$education] ?? 0;

            $creditPurpose = array(
                278 => 13488,
                279 => 13476,
                280 => 13491,
                281 => 13481,
                282 => 13480,
                283 => 13477,
                284 => 13483,
                285 => 13484,
                286 => 13474,
                287 => 13487,
                288 => 13482,
                289 => 13490,
                290 => 13489,
                291 => 13492,
                292 => 13486,
                293 => 13485,
                294 => 13478,
                295 => 13479,
                296 => 13473,
                297 => 13475,
                298 => 13493,
            );


            $data['data']['creditPurpose'] = intval($creditPurpose[Functions::getValueText($id, 'creditPurpose')] ?? 0);

            $hasCreditCard = array(
                276 => 13494,
                277 => 13495,
            );

            $data['data']['hasCreditCard'] = intval($hasCreditCard[Functions::getValueText($id, 'hasCreditCard')] ?? 0);

            $income = array(
                43 => 86,
                44 => 85,
                45 => 84,
                46 => 83,
                47 => 82,
                48 => 81,
            );

            $data['data']['income'] = intval($income[Functions::getValueText($id, 'income')] ?? 0);

            $activeCredits = array(
                56 => 69,
                57 => 13458,
                58 => 13459,
                59 => 13460,
                60 => 13461,
                61 => 13462,
                62 => 13463,
                63 => 13464,
                64 => 13465,
                65 => 13466,
                66 => 13467,
                67 => 13468,
                68 => 13469,
                69 => 13471,
                70 => 13472,
            );

            $data['data']['activeCredits'] = intval($activeCredits[Functions::getValueText($id, 'activeCredits')] ?? 0);


            $data['data']['index'] = Functions::getValueText($id, 'index');
            $data['data']['city'] = $this->checkFIAS($id, 'city');
            $data['data']['street'] = Functions::getValueText($id, 'street');
            $data['data']['house'] = Functions::getValueText($id, 'house');
            $data['data']['building'] = Functions::getValueText($id, 'building');
            $data['data']['structure'] = Functions::getValueText($id, 'structure');
            $data['data']['apartment'] = Functions::getValueText($id, 'apartment');
            $data['data']['index1'] = Functions::getValueText($id, 'index1');
            $data['data']['city1'] = $this->checkFIAS($id, 'city1');
            $data['data']['street1'] = Functions::getValueText($id, 'street1');
            $data['data']['house1'] = Functions::getValueText($id, 'house1');
            $data['data']['building1'] = Functions::getValueText($id, 'building1');
            $data['data']['structure1'] = Functions::getValueText($id, 'structure1');
            $data['data']['apartment1'] = Functions::getValueText($id, 'apartment1');

            $data['signature'] = base64_encode(sha1(json_encode($data['data']) . $pass, true));
        } catch (Exception $e) {
            $this->response(1, 'Неполные данные');
        }
//        echo '<pre>'; var_dump($data); die;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://crm.4slovo.ru/requestAPI.php');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result = curl_exec($ch);

        curl_close($ch);

        $r = json_decode($result, true);

        $query = "insert into app_log set app_id = :app_id, channel_id = :channel_id, ts = now(), status = :status, success = :success, message = :message ";
        $data = array('app_id' => $id, 'channel_id' => 4, 'status' => 1, 'success' => (isset($r['errorcode']) && $r['errorcode'] ? 0 : 1), 'message' => $result);
        $sth = self::getDb()->prepare($query);
        $sth->execute($data);
//        var_dump($r); die;
        $this->response($r['errorcode'] ? 0 : 1, $r['errorcode'] ? $r['error'] : $r['link']);
    }

}