<?php
namespace App\Api\RequestAPI;

use App\Api\Config;

class RequestAPICheckWorkingTime
{
    private $workingTime;

    public function __construct()
    {
        $this->workingTime = json_decode(Config::get('requestAPI.workingTime'), true);
        if (empty($this->workingTime)) {
            $this->workingTime = array();
        }
    }

    public function check()
    {
        $outOfService = false;
        $day = date('w');
        if (isset($this->workingTime[$day])) {
            if ($this->workingTime[$day] != '*') {
                $currentTime = new \DateTime();
                $workTimeBegin = new \DateTime();
                $workTimeEnd = new \DateTime();
                $startTime = explode(':', $this->workingTime[$day]['s']);
                $endTime = explode(':', $this->workingTime[$day]['e']);
                $workTimeBegin->setTime($startTime[0], $startTime[1], 0);
                $workTimeEnd->setTime($endTime[0], $endTime[1], 0);
                if ($currentTime < $workTimeBegin || $currentTime > $workTimeEnd) {
                    $outOfService = true;
                }
            }
        } else {
            $outOfService = true;
        }

        if ($outOfService) {
            throw new RequestAPIException(RequestAPIResponseCode::OUT_OF_SERVICE);
        }


    }
}
