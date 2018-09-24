<?php

namespace App\Twig;

use App\Proxy;
use App\Cfg\Config;
use App\Controller\Actions\Autorize;
use Symfony\Component\HttpFoundation\Response;


class Render
{
    /**
     * @param array $data
     * @param string|null $template
     * @return Response
     */
    public function render(array $data, string $template = null)
    {
        if(Config::isAutorizeObligatory() && !(new Autorize())->isLogged()){
            $tpl = Config::getTwigLoginTemplate();
        } else {
            $tpl = $template ?? Config::getTwigDefaultTemplate();
        }
        return new Response(
            Proxy::init()->getTwigEnvironment()->render(
                $tpl,
                $data
            )
        );
    }
}