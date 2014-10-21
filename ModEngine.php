<?php
use mods\Mode;

/**
 * Created by 5to5 Web.
 * User: Nik
 * Date: 21.10.14
 * Time: 22:18 
 */

class ModEngine
{
    protected $mods = array();

    function __construct($mods)
    {
        /** @var $mod Mode */
        foreach ($mods as $mod) {
            $this->mods[$mod->getModeName()] = $mod;
        }
        //$this->mods = $mods;
    }

    public function modernize(RouteInterface $route)
    {
        $listeners = array();
        foreach ($route->getMods() as $modName => $modConfig)
        {
            /** @var $mod Mode */
            $mod = $this->mods[$modName];
            $tmp = $mod->modernize($modConfig);

            if($tmp === null)
                continue;

            list($event,$listener) = $tmp;

            if(!isset($listeners[$event]))
                $listeners[$event] = array();

            $listeners[$event][] = $listener;
        }
        return new ModdedRoute($listeners,$route);
    }


    /*public function createReflection()
    {
        $rClass = new ReflectionClass(RouteInterface::class);
        foreach ($rClass->getMethods() as $method)
        {

        }
    }*/
}