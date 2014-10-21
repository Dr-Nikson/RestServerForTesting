<?php
/**
 * Created by 5to5 Web.
 * User: Nik
 * Date: 21.10.14
 * Time: 22:26 
 */

namespace mods;

use Route;

abstract class Mode
{
    protected abstract function getModeClassName();

    /**
     * @param $routeConfig
     * @return Route
     */
    public abstract function modernize($routeConfig);

    public function getModeName()
    {
        return ltrim(ltrim($this->getModeClassName(),__NAMESPACE__),'\\');
    }
}