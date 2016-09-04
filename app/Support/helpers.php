<?php

/*
|--------------------------------------------------------------------------
| Detect Active Route
|--------------------------------------------------------------------------
|
| Compare given route with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function isActiveRoute($route, $output = null, $arg = null, $value = null)
{
    $output = $output === null ? 'uk-active' : $output;
    if($arg === null || $value == null) {
        return (Route::currentRouteName() == $route) ? $output : '';
    } else {
        return (Route::getCurrentRoute()->getAction()['as'] === $route && Route::getCurrentRoute()->{$arg} == $value) ? $output : '';
    }
}

/*
|--------------------------------------------------------------------------
| Detect Active Routes
|--------------------------------------------------------------------------
|
| Compare given routes with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function areActiveRoutes(Array $routes, $output = "uk-active")
{
    foreach ($routes as $route) {
        if (Route::currentRouteName() == $route) return $output;
    }
    return '';
}