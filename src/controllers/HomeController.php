<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler; //liberando o uso do handler

class HomeController extends Controller {

    private $loggedUser; //armazenamento do token

    public function __construct() { //a funcao construtora vai ser a primeria a rodar, entao caso o token nao seja reconhecido, ele ja redireciona
        $this->$loggedUser = LoginHandler::checkLogin(); //aqui e criado a instancia de armazenamento do login
        if($this->$loggedUser === false) {

            $this->redirect('/login');
        }
    }

    public function index() {
        $this->render('home', ['nome' => 'Rodrigo']);
     }

}