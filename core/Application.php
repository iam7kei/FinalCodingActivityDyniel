<?php

namespace app\core;

use app\controllers\Controller;
use app\models\CustomerModel;

class Application
{
    public static string $ROOT_DIR;
    public string $userClass;
    public bool $isGuest = true;

    public Database $db;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public ?DbModel $user;
    public static Application $app;

    public Controller $controller;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->userClass = $config['userClass'];
        $userID = $this->session->get('user');

        if ($userID) {
            $primaryKey = $this->userClass::getPrimaryKey();
            $this->user = $this->userClass::findUser([$primaryKey => $userID]);
        } else {
            $this->user = null;
        }
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->getPrimaryKey();
        $userID = $user->{$primaryKey};
        $this->session->set('user', $userID);
        $this->isGuest = false;
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}
