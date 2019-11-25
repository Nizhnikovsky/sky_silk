<?php


namespace App\Core;

use App\Core\DB\Connection;

class App
{
    /** @var Router */
    private static $router;

    /** @var DB\IConnection */
    private static $conn;

    /** @var Session */
    private static $session;

    private static $redis;


    /**
     * @return Session
     */
    public static function getSession(): Session
    {
        return self::$session;
    }

    /**
     * @return mixed
     */
    public static function getRedis()
    {
        self::$redis->connect(
            Config::get('redis.host'),
            Config::get('redis.port')
        );
        return self::$redis;
    }

    /**
     * @return Router
     */
    public static function getRouter(): Router
    {
        return self::$router;
    }

    /**
     * @return DB\IConnection
     */
    public static function getConnection(): DB\IConnection
    {
        return self::$conn;
    }

    /**
     * @param $uri
     * @throws \Exception
     */
    public static function run($uri)
    {
        static::$redis = new \Redis();

        static::$conn = Connection::getConnection();

        static::$router = new Router($uri);
        static::$session = Session::getInstance();

        $route = static::$router->getRoute();
        $className = static::$router->getController();
        $action = static::$router->getAction();
        $params = static::$router->getParams();

        Localization::setLang(static::$router->getLang());
        Localization::load();

        $controllerName = '\App\Controllers\\'
            .($route == Config::get('adminRoute') ? 'Admin\\' : '')
            .$className;

        if (!class_exists($controllerName)) {

            $layout = new \App\Views\Base(
                [],
                ROOT.DS.'views'.DS.'404.php'
            );
            echo $layout->render();
            die(404);
        }

        /** @var \App\Controllers\BaseController $controller */
        $controller = new $controllerName($params);

        if (!method_exists($controller, $action)) {
            throw new \Exception('Action '.$action.' not found in '.$controllerName);
        }

        if (!$controller instanceof \App\Controllers\BaseController) {
            throw new \Exception('Controller must extend Base class');
        }

        ob_start();

        $controller->$action();

        $view = new \App\Views\Base(
            $controller->getData(),
            $controller->getTemplate()
        );

        $content = $view->render();

        $layout = new \App\Views\Base(
            ['content' => $content],
            ROOT.DS.'views'.DS.$route.'.php'
        );

        echo $layout->render();

        ob_end_flush();
    }





}
