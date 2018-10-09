<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController
{
     /**
      * @Route("/app")
      */
    public function app()
    {
        return new Response(
            '<html><body>app</body></html>'
        );
    }
}