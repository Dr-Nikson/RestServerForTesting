<?php
/**
 * Created by 5to5 Web.
 * User: Nik
 * Date: 11.10.14
 * Time: 17:06 
 */

class Route
{
    protected $url;
    protected $method;
    protected $status = 200;
    protected $delay = 50;
    protected $response =  null;
    protected $params = null;

    /**
     *
     */
    const regexp_id = '[0-9]+';

    protected $urlReg;

    function __construct($jsonRouteData)
    {
        if(!isset($jsonRouteData->url))
            throw new ServerException('Wrong route config: url not specified');
        $this->url = $jsonRouteData->url;

        if(!isset($jsonRouteData->method))
            throw new ServerException('Wrong route config: method not specified');
        $this->method = $jsonRouteData->method;

        if(isset($jsonRouteData->status))
            $this->status = $jsonRouteData->status;

        if(isset($jsonRouteData->delay))
            $this->delay = $jsonRouteData->delay;

        if(isset($jsonRouteData->response))
            $this->response = $jsonRouteData->response;

        if(isset($jsonRouteData->params))
            $this->params = $jsonRouteData->params;

        $this->processUrlReg();
    }

    /**
     * @return mixed
     */
    public function getUrlReg()
    {
        return $this->urlReg;
    }

    /**
     * @return int
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return null
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * @return string
     */
    protected function processUrlReg()
    {
        //$url = preg_quote($url);
        $url = str_replace('/','\/',$this->url);

        if(strpos($url,'{id}') !== false)
        {
            $url = str_replace('{id}',self::regexp_id,$url);
        }

        $this->urlReg =  $this->addRegexpSymbols($url);
    }


    /**
     * @param $url
     * @return string
     */
    protected function addRegexpSymbols($url)
    {
        return '/^' . $url . '$/';
    }
}