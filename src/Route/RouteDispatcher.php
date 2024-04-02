<?php

namespace src\Route;

use JetBrains\PhpStorm\NoReturn;
use src\View\View;

class RouteDispatcher
{
    private string $requestUri = '/';
    private RouteConfiguration $routeConfiguration;
    private array $paramMap = [];
    private array $paramRequestMap = [];

    /**
     * @param RouteConfiguration $routeConfiguration
     */
    public function __construct(RouteConfiguration $routeConfiguration)
    {
        $this->routeConfiguration = $routeConfiguration;
    }

    public function process(): void
    {
        $this->saveRequestUri();
        $this->setParamMap();
        $this->makeRegexRequest();
        $this->run();
    }

    private function saveRequestUri(): void
    {
        if ($_SERVER['REQUEST_URI'] !== '/') {
            $this->requestUri = $this->clean($_SERVER['REQUEST_URI']);
            $this->routeConfiguration->route = $this->clean($this->routeConfiguration->route);
        }
    }
    private function clean(string $str): array|string|null
    {
        return preg_replace('/(^\/)|(\/$)/', '', $str);
    }

    private function setParamMap(): void
    {
        $routeArray = explode('/', $this->routeConfiguration->route);

        foreach ($routeArray as $paramKey => $param) {
            if (preg_match('/{.*}/', $param)) {
                $this->paramMap[$paramKey] = preg_replace('/(^{)|(}$)/', '', $param);
            }
        }

    }

    public function makeRegexRequest(): void
    {
        $requestUriArray = explode('/', $this->requestUri);

        foreach ($this->paramMap as $paramKey => $param) {
            if (!isset($requestUriArray[$paramKey])) {
                return;
            }
            $this->paramRequestMap[$param] = $requestUriArray[$paramKey];
            $requestUriArray[$paramKey] = '{.*}';
        }
        $this->requestUri = implode('/', $requestUriArray);
    }

    private function run(): void
    {
        $requestUri = preg_replace("/{.*}/",'', $this->requestUri);
        $route = preg_replace("/{.*}/",'', $this->routeConfiguration->route);
        if ($requestUri === $route){
            $this->render();
        }
    }


    #[NoReturn] private function render(): void
    {
        $Class = $this->routeConfiguration->controller;
        $method = $this->routeConfiguration->action;
        (new $Class())->$method(...$this->paramRequestMap);

        die();
    }



}