<?php

use mods\GetRandomFromArrayMode;
use mods\RandomizeFieldMode;
use mods\ResultsOffsetMode;
use mods\UnsetField;

require_once 'ClientException.php';
require_once 'RouteInterface.php';
require_once 'Router.php';
require_once 'ModdedRoute.php';
require_once 'ModEngine.php';
require_once 'mods/Mode.php';
require_once 'mods/GetRandomFromArrayMode.php';
require_once 'mods/RandomizeFieldMode.php';
require_once 'mods/UnsetField.php';
require_once 'mods/ResultsOffsetMode.php';


try
{
    ob_start();

    if (!isset($_GET['customUrl']))
        throw new ClientException('API URL not specified');

    $routesData = json_decode(file_get_contents('routes.config.json'));
    $url = rtrim($_GET['customUrl'],'/');
    $router = new Router($routesData);
    $modEngine = new ModEngine(array( new GetRandomFromArrayMode(), new RandomizeFieldMode(), new UnsetField(), new ResultsOffsetMode() ));
    $route = $router->getMatchingRoute($url);
    $route = $modEngine->modernize($route);
    process($route);
}
catch (ClientException $ce)
{
    printResponse(printHeaderByName('400'), function () use (&$ce) {
        print(json_encode($ce->getMessage()));
    });
}
catch (Exception $e)
{
    printResponse(printHeaderByName('500'), function () use (&$e) {
            print(json_encode($e->getMessage()));
        });
}


function process(RouteInterface $route)
{
    //if(isset($route->getDelay()))
    usleep($route->getDelay()*1000);

    $responseBody = '';
    if(($responseBody = $route->getResponse()) === null)
        $responseBody = '';
    //$responseBody = file_get_contents($route->getResponse());

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