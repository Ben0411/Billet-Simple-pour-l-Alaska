<?php

namespace Framework;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing;

use Symfony\Component\Config\FileLocator;

use Symfony\Component\Yaml\Yaml;

use Framework\Config\Routes;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;



class App
{
    static public function run($devMode = false ) {
        $request = Request::createFromGlobals();  
        if($request->getSession() === null){
        $request->setSession(new Session()); 
        }
        $request->getSession()->start();
        $router = self::getRouter();
        if (preg_match('/^\/admin\//',$request->getPathInfo()) && !$request->getSession()->has("AUTH")){
            $context = new RequestContext('');
            $generator = new UrlGenerator($router["collection"], $context);
            $response = new RedirectResponse($generator->generate('login',array()));
            $response->send();
        }
        
        list($controller,$action) = explode("::",array_shift($router["route"]));
        $controller = "\Controller\\".$controller;
        $controller = new $controller($request, $router["collection"], self::loadConfig($devMode), array_pop($router["route"]));
       

        call_user_func_array(array($controller,$action), $router["route"]);
        }

    static public function loadConfig($devMode)
    {
        $config = Yaml::parse(file_get_contents(__DIR__."/config/config.yml"));
        if($devMode){
            $config = array_merge($config,Yaml::parse(file_get_contents(__DIR__."/config/config_dev.yml")));
        }
        return $config;
    }

    static private function getRouter()
    {
        $request = Request::createFromGlobals();
        $context = new Routing\RequestContext();
        $context->fromRequest($request);

        $locator = new FileLocator(array(__DIR__."/config"));

        $router = new Routing\Router(
            new Routing\Loader\YamlFileLoader($locator),
            'routing.yml',
            array(),
            $context
        );
   
        return array("route"=>$router->match($request->getPathInfo()),"collection"=> $router->getRouteCollection());
    }
    
    
}
