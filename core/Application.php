<?php

namespace app\core;

use app\controllers\Controller;
use app\controllers\SiteController;
use app\models\AdminModel;
use app\models\CustomerModel;
use Cassandra\Custom;

class Application
{
    public static string $ROOT_DIR;
    public string $userClass;
    public bool $isGuest = true;
    public array $currentUser = [];

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
        $this->session = new Session();
        $this->controller = new SiteController();
        $this->request = new Request();
        $this->response = new Response();
        $this->db = Database::getInstance();
        $currentUserClass = CustomerModel::tableName();

        if ($this->request->isAdmin()) {
            $currentUserClass = AdminModel::tableName();
        }
        $this->userClass = $config['userClass'][$currentUserClass];
        $userID = $this->session->get($this->userClass::getPrimaryKey());

        if ($userID) {
            $primaryKey = $this->userClass::getPrimaryKey();
            $this->user = $this->userClass::findRecord([$primaryKey => $userID]);
        } else {
            $this->user = null;
        }

        $this->router = new Router($this->request, $this->response);
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
        $this->session->set($primaryKey, $userID);
        $this->isGuest = false;
        return true;
    }

    public function logout(string $currentUser)
    {
        $this->user = null;
        $this->session->remove($currentUser);
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}
