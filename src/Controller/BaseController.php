<?php

namespace App\Controller;

use App\Proxy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


abstract class BaseController extends Controller
{

    const
        ADD_COMMENT = 'addcomment',
        FROM = '_from',
        TO = '_to',
        APP_ID = 'app_id',
        COMMENT = 'comment',
        APP = 'app',
        USERS = 'users',
        USER = 'user',
        USER_ROLES = 'user_roles',
        LIST_ROLES = 'list_roles',
        ROLES = 'roles',
        CREATE_FROM = 'create_from',
        CREATE_TO = 'create_to',
        CREATE_AT = 'createdat',
        UPDATE_FROM = 'update_from',
        UPDATE_TO = 'update_to',
        UPDATE_AT = 'updatedat',
        USER_ID = 'userId',
        PARTNER_ID = 'partnerId',
        PER_PAGE = 'per_page',
        DEFAULT_LIMIT = 50,
        SORT = 'sort',
        LIMIT = 'limit';


    public static $fields = [
        self::CREATE_AT => [self::FROM => self::CREATE_FROM, self::TO => self::CREATE_TO],
        self::UPDATE_AT => [self::FROM => self::UPDATE_FROM, self::TO => self::UPDATE_TO]
    ];


    /**
     * @var Request
     */
    private static $request;

    public function __construct()
    {
        self::$request = Request::createFromGlobals();
        Proxy::init()->initTwig();
        Proxy::init()->initDoctrine();
        Proxy::init()->initSession()->getSession()->start();
        Proxy::init()->initValidator();
        Proxy::init()->initLogger();
    }

    /**
     * @return Request
     */
    public static function getRequest(): Request
    {
        return self::$request;
    }

}