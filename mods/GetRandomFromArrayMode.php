<?php
/**
 * Created by 5to5 Web.
 * User: Nik
 * Date: 21.10.14
 * Time: 22:11 
 */

namespace mods;

use Route;

class GetRandomFromArrayMode extends Mode
{
    protected function getModeClassName()
    {
        return static::class;
    }

    /**
     * @param $modConfig
     * @return Route
     */
    public function modernize($modConfig)
    {
        /*if($modConfig == false)
            return null;*/
        return array(
            'getResponse',
            function ($r) {
                $r = json_decode($r);
                $rnd = rand(0,count($r));
                return json_encode($r[$rnd]);
            }
        );
    }
}