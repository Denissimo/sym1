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
        ROWS = 'rows_for_iteration'
    ;
    /**
     * @Route("options", name="options")
     * @return Response
     */
    public function options()
    {

        $data = [
            self::DISTR => (new Params())->get(self::DISTR),
            self::ROWS => (new Params())->get(self::ROWS)
        ];
        return (new Render())->render($data, 'options.html.twig');
    }
}