<?php
/**
 * Created by PhpStorm.
 * User: Den
 * Date: 21.09.2018
 * Time: 8:41
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class MyController
{
    public function run()
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}