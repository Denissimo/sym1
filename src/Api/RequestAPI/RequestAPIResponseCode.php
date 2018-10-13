<?php
namespace App\Api\RequestAPI;

class RequestAPIResponseCode
{
    const OK = 0;
    const OUT_OF_SERVICE = 1;
    const BAD_SIGNATURE = 2;
    const BAD_FIELD = 3;
    const BAD_FIELD_SURNAME = 301;
    const BAD_FIELD_NAME = 302;
    const BAD_FIELD_PATRONYMIC = 303;
    const BAD_FIELD_SEX = 304;
    const BAD_FIELD_MOBILE = 305;
    const BAD_FIELD_EMAIL = 306;
    const BAD_FIELD_BIRTHDATE = 307;
    const BAD_FIELD_PASSPORT_ID = 308;
    const BAD_FIELD_RESIDENCE = 309;
    const BAD_FIELD_AMOUNT = 310;
    const BAD_FIELD_TERM = 311;
    const DUPLICATE_REQUEST = 4;
    const BAD_PERSON_PASSPORT = 51;
    const BAD_PERSON_PHONE = 52;
    const BAD_PERSON_BLACKLIST = 53;
    const BAD_PERSON_BROKER = 54;
    const BAD_PARTNER = 6;
    const REQUEST_LIMIT = 7;

    public static $codeDescription = array(
        self::OUT_OF_SERVICE => 'Out of service',
        self::BAD_SIGNATURE => 'Bad signature',
        self::BAD_FIELD => 'Bad field',
        self::BAD_FIELD_SURNAME => 'Surname error',
        self::BAD_FIELD_NAME => 'Name error',
        self::BAD_FIELD_PATRONYMIC => 'Patronymic error',
        self::BAD_FIELD_SEX => 'Sex error',
        self::BAD_FIELD_MOBILE => 'Mobile error',
        self::BAD_FIELD_EMAIL => 'Email error',
        self::BAD_FIELD_BIRTHDATE => 'Birthdate error',
        self::BAD_FIELD_PASSPORT_ID => 'Passport_id error',
        self::BAD_FIELD_RESIDENCE => 'Residence error',
        self::BAD_FIELD_AMOUNT => 'Amount error',
        self::BAD_FIELD_TERM => 'Term error',
        self::DUPLICATE_REQUEST => 'Duplicate request',
        self::BAD_PERSON_PASSPORT => 'Bad person',
        self::BAD_PERSON_PHONE => 'Bad person',
        self::BAD_PERSON_BLACKLIST => 'Bad person',
        self::BAD_PERSON_BROKER => 'Bad person',
        self::BAD_PARTNER => 'Partner not found',
        self::REQUEST_LIMIT => 'Request limit',
    );

    public static function getCodeDescription($code)
    {
        return self::$codeDescription[$code];
    }
}
