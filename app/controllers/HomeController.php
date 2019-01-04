<?php


namespace App\controllers;
require __DIR__ . '/../../vendor/autoload.php';


use App\QueryBuilder;
use League;
use League\Plates\Engine;
use App\Db;

class HomeController
{
    protected $db;
    protected $templates;
    public $auth;
    
    
    public function __construct(UserController $user, QueryBuilder $queryBuilder, Engine $engine)
    {
        //$this->user = new UserController();
        $this->auth = $user->auth;
        $this->db = $queryBuilder;
        $this->templates = $engine;
    }
    
    public function index()
    {
        $posts = $this->db->selectAll('posts');
        echo $this->templates->render('index', ['posts' => $posts, 'auth' => $this->auth]);
    }
    
    public function read($vars)
    {
        $post = $this->db->selectOne($vars['id'], 'posts');
        echo $this->templates->render('read', ['post' => $post]);
    }
    
    public function edit($vars)
    {
        $post = $this->db->selectOne($vars['id'], 'posts');
        echo $this->templates->render('edit', ['post' => $post]);
    }
    
    public function editPost()
    {
        //d($_POST);
        if (isset($_POST['id'])) {
            
            $id = $_POST['id'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $this->db->update($id, 'posts', $title, $content);
            
        }
        header('Location: /');
    }
    
    public function create()
    {
        echo $this->templates->render('create', ['auth' => $this->auth]);
    }
    
    public function createPost()
    {
        //d($_POST);die;
        if (isset($_POST['title']) && isset($_POST['content'])) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $create_id = (int)$_POST['id'];
            $this->db->insert('posts', $title, $content, $create_id);
            
        }
        header('Location: /');
    }
    
    public function delete($vars)
    {
        $post = $this->db->delete($vars['id'], 'posts');
        header('Location: /');
    }
    
}