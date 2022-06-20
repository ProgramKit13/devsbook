<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler;


class LoginController extends Controller {

    public function signin() {
        $flash = '';
        if(!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        $this->render('signin', [
            'flash' => $flash
        ]);
     }

     public function signinAction() {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if($email && $password) {
            $token = LoginHandler::verifyLogin($email , $password);
            if($token) {
                $_SESSION['token'] = $token;
                $this->redirect('/');
            } else {
                $_SESSION['flash'] = 'Email e/ou senha nao conferem.';
                $this->redirect('/login');
            }
        } else {
            $this->redirect('/login');
        }
    }

     public function signup() {
        $flash = '';
        if(!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        $this->render('signup', [
            'flash' => $flash
        ]);
     }

     public function signupAction() {
        $name = filter_input(INPUT_POST, 'name');
        $birthdate = filter_input(INPUT_POST, 'birthdate');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if($name && $birthdate && $email && $password) {
            $birthdate = explode('/', $birthdate);
            if(count($birthdate) != 3) {
                $_SESSION['flash'] = 'Data de nascimento inválida';
                //$this->redirect('/cadastro');
                echo 'erro1';
            }

            $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];
            if(strtotime($birthdate) === false) {
                $_SESSION['flash'] = 'Data de nascimento inválida';
                //$this->redirect('/cadastro');
                echo 'erro2';
            }

            if(LoginHandler::emailExistis($email) === false) {
                $token = LoginHandler::addUser($name, $birthdate, $email, $password);
                $_SESSION['token'] = $token;
                //$this->redirect('/');
                print_r($_SESSION['token']);
                echo 'cadastro';
            } else {
                $_SESSION['flash'] = 'E-mail já cadastrado.';
                //$this->redirect('/cadastro');
                echo 'erro3';
            }
        } else {
            echo 'erro 4';
            //$this->redirect('/cadastro');
        }
     }
    

}