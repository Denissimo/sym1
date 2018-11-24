<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Twig\Render;
use App\Params\Params;


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
        return (new Render())->render($data, 'options.html.twig');
    }
}