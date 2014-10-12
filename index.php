<?php

require_once 'ClientException.php';
require_once 'Router.php';

try
{
    ob_start();

    if (!isset($_GET['customUrl']))
        throw new ClientException('API URL not specified');

    $routesData = json_decode(file_get_contents('routes.config.json'));
    $url = rtrim($_GET['customUrl'],'/');
    $router = new Router($routesData);
    process($router->getMatchingRoute($url));
}
catch (ClientException $ce)
{
    printResponse(printHeaderByName('400'), function () use (&$ce) {
        print($ce->getMessage());
    });
}
catch (Exception $e)
{
    printResponse(printHeaderByName('500'), function () use (&$e) {
            print($e->getMessage());
        });
}


function process(Route $route)
{
    //if(isset($route->getDelay()))
    usleep($route->getDelay()*1000);

    $responseBody = '';
    if($route->getResponse() !== null)
        $responseBody = file_get_contents($route->getResponse());

    $responseStatus = $route->getStatus();

    printResponse(printHeaderByName($responseStatus),function() use($responseBody) {
            print($responseBody);
        });
}


function printResponse(Closure $headers, Closure $body)
{
    $ob = ob_get_contents();
    ob_end_clean();
    $crossDomainHeader = printHeaderByName('cross-domain');
    //$crossDomainHeader();
    $headers();
    $body();
}


/**
 * @param $name
 * @return callable
 */
function printHeaderByName($name)
{
    switch($name)
    {
        case 'cross-domain':
            return function () {header("Access-Control-Allow-Origin: http://localhost:8000"); };

        case '500':
            //return function () { header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500); };
            return function () { http_response_code(500); };
            break;

        case '400':
            return function () { http_response_code(400); };
            break;

        case '200':
        default: return function() {};
    }
}