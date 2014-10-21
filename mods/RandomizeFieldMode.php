<?php
/**
 * Created by 5to5 Web.
 * User: Nik
 * Date: 21.10.14
 * Time: 23:50 
 */

namespace mods;


use Route;

class RandomizeFieldMode extends Mode
{

    protected function getModeClassName()
    {
        return static::class;
    }

    /**
     * @param $routeConfig
     * @return Route
     */
    public function modernize($routeConfig)
    {
        return array(
            'getResponse',
            function ($r) use(&$routeConfig) {
                $r = json_decode($r);
                $min = $routeConfig->min;
                $max = $routeConfig->max;
                $field = $routeConfig->field;
                $rnd = rand($min,$max);
                $r->$field = $rnd;
                return json_encode($r);
            }
        );
    }
}