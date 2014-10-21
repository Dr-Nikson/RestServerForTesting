<?php
/**
 * Created by 5to5 Web.
 * User: Nik
 * Date: 21.10.14
 * Time: 23:07 
 */

class ModdedRoute implements RouteInterface
{
    protected $listeners;
    protected $route;

    function __construct($listeners,RouteInterface $route)
    {
        $this->listeners = $listeners;
        $this->route = $route;
    }

    public function getUrlReg()
    {
        return $this->callListener('getUrlReg',$this->route->getUrlReg());
    }

    public function getDelay()
    {
        return $this->callListener('getDelay',$this->route->getDelay());
    }

    public function getMethod()
    {
        return $this->callListener('getMethod',$this->route->getMethod());
    }

    public function getParams()
    {
        return $this->callListener('getParams',$this->route->getParams());
    }

    public function getResponse()
    {
        return $this->callListener('getResponse',$this->route->getResponse());
    }

    public function getStatus()
    {
        return $this->callListener('getStatus',$this->route->getStatus());
    }

    public function getUrl()
    {
        return $this->callListener('getUrl',$this->route->getUrl());
    }

    public function getMods()
    {
        return $this->callListener('getMods',$this->route->getMods());
    }

    protected function callListener($name,$data)
    {
        if(!isset($this->listeners[$name]))
        {
            return $data;
        }

        foreach ($this->listeners[$name] as $listener)
        {
            $data = $listener($data);
        }

        return $data;
    }
}