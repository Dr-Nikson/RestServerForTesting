<?php
/**
 * Created by 5to5 Web.
 * User: Nik
 * Date: 05.11.14
 * Time: 2:06 
 */

namespace mods;


use Route;

class ResultsOffsetMode extends Mode
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
                $pageSize = $_GET['limit'];
                $total = count($r->results);
                $offset = $_GET['offset'];

                if($offset > $total)
                    throw new \ClientException('Wrong offset');

                $arr = array();
                for($i = $offset, $j = 0; $i < $total && $j < $pageSize; ++$i, ++$j)
                {
                    $arr[] = $r->results[$i];
                }

                $r->offset = $offset;
                $r->count->total = $total;
                $r->count->current = count($arr);
                $r->count->remaining = $total - $offset - $r->count->current;

                if($r->count->remaining < 0)
                    $r->count->remaining = 0;

                $r->results = $arr;
                return json_encode($r);
            }
        );
    }
}