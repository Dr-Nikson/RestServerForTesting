<?php
/**
 * Created by 5to5 Web.
 * User: Nik
 * Date: 21.10.14
 * Time: 22:41 
 */

interface RouteInterface
{
    public function getUrlReg();
    public function getDelay();
    public function getMethod();
    public function getParams();
    public function getResponse();
    public function getStatus();
    public function getUrl();
    public function getMods();
}