<?php
namespace App\Api\Teleport;

use App\Proxy;

class Teleport
{
	private static $uid;

	private static $url;

	private static $errors = array('error', 'error double', 'error incomplete');

	/**
	 * Отправляет запрос в телепорт и смотрит ответ от них
	 * Записывает время в регистрацию, в поле teleport_ts
	 * @param array $xml_data Принимает массив с готовыми данными для отправки в xml формате
	 * @throws string Exception    Отправка останавливается если Response unauthorized
	 * или не совпадает с success и $errors
	 */
	private static function sendRequest($xml_data)
	{ 	
		foreach ($xml_data as $id => $data) {
			$param = array(
				'UID' => self::$uid,
				'data' => $data['xml_data']
			);

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, self::$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 1);

			$response = curl_exec($ch);
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$header = substr($response, 0, $header_size);
			$body = trim(substr($response, $header_size));
			curl_close($ch);
			
			$query = "insert into app_log set app_id = :app_id, channel_id = :channel_id, ts = now(), status = :status, success = :success, message = :message ";
			$data = array('app_id' => $id, 'channel_id' => 2, 'status' => 1, 'success' => ($body == 'success' ? 1 : 0), 'message' => $body);
			$sth =  Proxy::init()->initDoctrine()->getConnecton()->prepare($query);
//			$sth = DB::get()->prepare($query);
			$sth->execute($data);


		}

	}

	/**
	 * @param int $days Принимает количество дней на который брался займ
	 * @return int  $weeks Подсчитывает и возвращает количество недель.
	 */
	private static function convertDaysToWeek($days)
	{
		$weeks = 0;
		while ($days > 0) {
			$weeks = $weeks + 1;
			$days = $days - 7;
		}

		return $weeks;
	}

	private static function convertIncome($param)
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
	

	private static function convertToXML($users)
	{
		
		$record_of_services = array(
			71 => '0',
			72 => '3',
			73 => '6',
			74 => '12',
			75 => '36',
			76 => '84'
		);
		
		$xml_data = array();

		foreach ($users as $user) {
			
			$id = $user['id'];

			$passport = preg_replace('/\D/', '', Functions::getValueText($id, 'passportNumber'));

			$xml_data[$id]['xml_data'] = '<?xml version="1.0" encoding="UTF-8"?>
<requests>
<request>
	<id>' . $id . '</id>
	<subid>' . ($user['partner_id'] == 2 ? '666' : '777') . '</subid>
	<amount>' . Functions::getValueText($id, 'creditAmount') . '</amount>
	<period>' . self::convertDaysToWeek(Functions::getValueText($id, 'creditTerm')) . '</period>
	<last_name>' . Functions::getValueText($id, 'secondName') . '</last_name>
	<first_name>' . Functions::getValueText($id, 'name') . '</first_name>
	<middle_name>' . Functions::getValueText($id, 'middleName') . '</middle_name>
	<phone>' . Functions::getValueText($id, 'mobileNumber') . '</phone>
	<birthday>' . preg_replace('/(\d{2})\.(\d{2})\.(\d{4})/ims', '\\3-\\2-\\1', Functions::getValueText($id, 'birthDate')) . '</birthday>
	<email>' . Functions::getValueText($id, 'email') . '</email>
	<id_sex>' . Functions::getValueTextId($id, 'sex') . '</id_sex>
	<inn_number></inn_number>
	<passport_series>' . substr($passport, 0, 4) . '</passport_series>
	<passport_number>' . substr($passport, 4, 6) . '</passport_number>
	<passport_date_of_issue>' . preg_replace('/(\d{2})\.(\d{2})\.(\d{4})/ims', '\\3-\\2-\\1', Functions::getValueText($id, 'passportDate')) . '</passport_date_of_issue>
	<birthplace>' . Functions::getValueText($id, 'birthPlace') . '</birthplace>
	<passport_org>' . Functions::getValueText($id, 'passportWho') . '</passport_org>
	<incoming>' . self::convertIncome(Functions::getValueTextId($id, 'income')) . '</incoming>
	<experience>' . (isset($record_of_services[Functions::getValueTextId($id, 'record')]) ? $record_of_services[Functions::getValueTextId($id, 'record')] : '') . '</experience>
	<residential_region>' . Functions::getValueItem($id, 'region1') . '</residential_region>
	<residential_city>' . Functions::getValueText($id, 'city1') . '</residential_city>
	<residential_street>' . Functions::getValueText($id, 'street1') . '</residential_street>
	<residential_house>' . Functions::getValueText($id, 'house1') . '</residential_house>
	<residential_apartment></residential_apartment>
	<registration_region>' . Functions::getValueItem($id, 'region') . '</registration_region>
	<registration_city>' . Functions::getValueText($id, 'city') . '</registration_city>
	<registration_street>' . Functions::getValueText($id, 'street') . '</registration_street>
	<registration_house>' . Functions::getValueText($id, 'house') . '</registration_house>
	<registration_apartment></registration_apartment>
</request>
</requests>';
		}

		return $xml_data;
	}


	public static function main($credit, $uid, $url)
	{
		self::$uid = $uid;
		self::$url = $url;
		$input_xml = self::convertToXML($credit);
		self::sendRequest($input_xml);
	}
}
