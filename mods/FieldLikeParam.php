<?php
/**
 * Created by 5to5 Web.
 * User: Nik
 * Date: 30.10.14
 * Time: 21:02 
 */

namespace mods;

use Route;


class FieldLikeParam extends Mode
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
                $field = $routeConfig->field;
                $param = $routeConfig->param;
                $r->$field = $_REQUEST[$param];
                return json_encode($r);
            }
        );
    }
}