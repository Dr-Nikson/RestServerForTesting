<?php
/**
 * Created by 5to5 Web.
 * User: Nik
 * Date: 06.10.14
 * Time: 19:43 
 */

require_once 'Route.php';

class Router
{


    /**
     * @var string
     */
    protected $url = '';

    protected $routes = array();

    /**
     * @param $routesData
     */
    function __construct($routesData)
    {
        //$this->url = $url;
        $this->processRoutesData($routesData);
    }


    public function getMatchingRoute($url)
    {
        /** @var $route Route */
        foreach ($this->routes as $route)
        {
            if($this->isUrlMatches($url,$route->getUrlReg())
                && $this->isMethodMatches($route->getMethod())
                && $this->isParamsMatches($route->getParams()))
            {
                //process($route);
                //exit();
                return $route;
            }
        }

        throw new ClientException('API URL not found');
    }


    protected function isParamsMatches($params)
    {
        $flag = true;

        if(isset($params->GET))
        {
            foreach ($params->GET as $paramName => $paramValue)
            {
                $flag = $flag && $this->checkParam($paramName,$paramValue,$_GET);
            }
        }

        if(isset($params->POST))
        {
            foreach ($params->POST as $paramName => $paramValue)
            {
                $flag = $flag && $this->checkParam($paramName,$paramValue,$_POST);
            }
        }

        return $flag;
    }


    protected function isMethodMatches($method)
    {
        return (bool) (strtoupper($method) == $_SERVER['REQUEST_METHOD']);
    }


    /**
     * @param $url
     * @param $reg
     * @return bool
     */
    protected function isUrlMatches($url,$reg)
    {
        /*$reg = $this->processUrl($url);
        $this->processRegExp();*/
        $r = (bool) preg_match($reg,$url);
        return $r;
    }


    /**
     * @param $paramName Имя параметра
     * @param $paramData
     * @param $haystack Где искать (обычно $_GET или $_POST)
     * @return bool
     */
    protected function checkParam($paramName,$paramData,$haystack)
    {
        $result = true;
        foreach ($paramData as $type => $targetValue)
        {
            switch($type)
            {
                case 'equal':
                    $result = $result && $haystack[$paramName] == $targetValue;
                    break;
                case 'isset':
                    $result = $result && isset($haystack[$paramName]) == ((bool)$targetValue);
                    break;
            }
        }
        return $result;
    }


    protected function processRoutesData($data)
    {
        foreach($data as $routeData)
        {
            $route = new Route($routeData);
            $this->routes[] = $route;
        }
    }

}