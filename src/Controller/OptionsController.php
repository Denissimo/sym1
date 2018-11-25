<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Twig\Render;
use App\Params\Params;
use App\Controller\Actions\Autorize;


class OptionsController extends BaseController
{

    const
        DISTR = 'distribution',
        ROWS = 'rows_for_iteration',
        LIMIT = 'apps_limit_for_user'
    ;
    /**
     * @Route("options", name="options")
     * @return Response
     */
    public function options()
    {

        $data = [
            self::DISTR => (new Params())->get(self::DISTR),
            self::ROWS => (new Params())->get(self::ROWS),
            self::LIMIT => (new Params())->get(self::LIMIT)
        ];
        $data['command_proc'] = (new Autorize())->getAccessList()[Autorize::ACCESS_COMMAND_PROC];
        return (new Render())->render($data, 'options.html.twig');
    }
}