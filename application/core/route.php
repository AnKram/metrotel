<?php

class Route
{
    public static function start(): void
    {
        $controller_name = $controller_class_name = 'Contacts';
        $action_name = 'Index';
        $param = null;

        $url_without_get_params = array_shift(explode('?', $_SERVER['REQUEST_URI']));

        $routes = explode('/', $url_without_get_params);

        // get controller name
        if (!empty($routes[1])) {
            $controller_name = $routes[1];

            // get class name
            $controller_class_name = Route::getClassName($routes[1]);
        }

        // get action
        if (!empty($routes[2])) {
            $action_name = Route::getClassName($routes[2]);
        }

        if (!empty($routes[3]) && gettype($routes[3])) {
            $param = $routes[3];
        }

        $model_name = 'Model_' . $controller_name;
        $controller_name = 'Controller_' . $controller_name;
        $controller_class_name = 'Controller' . $controller_class_name;
        $action_name = 'action' . $action_name;

        // if model file exists - include it
        $model_file = strtolower($model_name) . '.php';
        $model_path = MODELS_PATH . $model_file;
        if (file_exists($model_path)) {
            include $model_path;
        }

        // include controller file
        $controller_file = strtolower($controller_name) . '.php';
        $controller_path = CONTROLLERS_PATH . $controller_file;

        if (file_exists($controller_path)) {
            include $controller_path;
        } else {
            //todo: add exception
            Route::ErrorPage404();
        }

        // create controller
        $controller = new $controller_class_name;
        $action = $action_name;

        if (!method_exists($controller, $action)) {
            //todo: add exception
            Route::ErrorPage404();
        } elseif (!is_null($param)) {
            // call action with param
            $controller->$action($param);
        } else {
            // call action without param
            $controller->$action();
        }
    }

    public static function getClassName(string $file_name): string
    {
        $name_parts = explode('_', $file_name);
        $class_name = '';
        foreach ($name_parts as $name_part) {
            $class_name .= ucfirst($name_part);
        }

        return $class_name;
    }

    public static function ErrorPage404(): void
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        //header('HTTP/1.1 404 Not Found');
        //header("Status: 404 Not Found");
        header('Location:' . $host . 'not_found');
    }
}