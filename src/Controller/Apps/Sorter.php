<?php

namespace App\Controller\Apps;


class Sorter
{

    /**
     * @param \Apps[][] $apps
     * @return \Apps[][]s
     */
    public function sortAll($apps)
    {   $sortedAppList = [];
        foreach ($apps as $key => $appsStatused){
            $timeZoneArray = $this->buildTimeZoneArray($appsStatused);
            $sortedAppList[$key] = $this->buildAppList($appsStatused, $timeZoneArray);
        }
        return $sortedAppList;
    }

    /**
     * @param \Apps[] $appsStatused
     * @return int[]
     */
    private function buildTimeZoneArray($appsStatused)
    {
        $timeZoneArray = [];
        foreach ($appsStatused as $key => $app) {
            $timeZoneArray[$key] = (int)$app->getTimeZone();
        }
        arsort($timeZoneArray);
        return $timeZoneArray;
    }

    /**
     * @param \Apps[] $appsStatused
     * @param int[] $timeZoneArray
     * @return \Apps[]
     */
    private function buildAppList($appsStatused, $timeZoneArray)
    {
        $sortedAppList = [];
        foreach ($timeZoneArray as $key => $timeZone) {
            $sortedAppList[] = $appsStatused[$key];
        }
        return $sortedAppList;
    }
}