<?php
/**
 * Created by PhpStorm.
 * User: Den
 * Date: 26.08.2018
 * Time: 16:56
 */

namespace src\Controller\LuckyController;


use Symfony\Component\HttpFoundation\Response;

class LuckyController
{
    public function number()
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}