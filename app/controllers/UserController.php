<?php

namespace App\controllers;

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../Db.php';

use App\Db;
use League;
use App\QueryBuilder;
use \Tamtamchik\SimpleFlash\Flash;


class UserController
{
    protected $dbh;
    protected $query;
    public $auth;
    protected $templates;
    protected $pdo;
    
    public function __construct(QueryBuilder $query, \PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->query = $query;
        $this->auth = new \Delight\Auth\Auth($this->pdo);
        $this->templates = new League\Plates\Engine(__DIR__ . '/../views/');
    }
    
    public function register()
    {
        echo $this->templates->render('register');
    }
    
    public function createUser()
    {
        if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repeat'])) {
            $users = $this->query->selectAll('users');
            
            foreach ($users as $user) {
                if ($user['email'] === $_POST['email']) {
                    \flash()->error('Email ' . $_POST['email'] . ' already in use!');
                    echo $this->templates->render('register');
                    die;
                }
            }
            
            if ($_POST['password'] !== $_POST['repeat']) {
                \flash()->error('Passwords are not the same!');
                echo $this->templates->render('register');
                die;
            }
            
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                \flash()->error('Email is not correct!!');
                echo $this->templates->render('register');
                die;
            }
            try {
                $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
                    echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                });
                
                echo 'We have signed up a new user with the ID ' . $userId;
            } catch (\Delight\Auth\InvalidEmailException $e) {
                die('Invalid email address');
            } catch (\Delight\Auth\InvalidPasswordException $e) {
                die('Invalid password');
            } catch (\Delight\Auth\UserAlreadyExistsException $e) {
                die('User already exists');
            } catch (\Delight\Auth\TooManyRequestsException $e) {
                die('Too many requests');
            }
            d($userId);
            header('Location: /');
            
        }
        
    }
    
    public function confirm()
    {
        try {
            $this->auth->confirmEmail($_GET['selector'], $_GET['token']);
            
            echo 'Email address has been verified';
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        } catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }
    
    public function login()
    {
        echo $this->templates->render('login');
    }
    
    public function loginUser()
    {
        if ($_POST['remember'] == 1) {
            // keep logged in for one year
            $rememberDuration = (int)(60 * 60 * 24 * 365.25);
        } else {
            // do not keep logged in after session ends
            $rememberDuration = null;
        }
        try {
            $this->auth->login($_POST['email'], $_POST['password'], $rememberDuration);
            //echo 'User is logged in';
            //$posts = $this->query->selectAll('posts');
            // echo $this->templates->render('index', ['posts' => $posts, 'auth' => $this->auth]);
            
            
        } catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
        header('Location: /');
    }
    
    public function logout()
    {
        $this->auth->logOut();
        //$posts = $this->query->selectAll('posts');
        //echo $this->templates->render('index', ['posts' => $posts, 'auth' => $this->auth]);
        header('Location: /');
    }
    
}