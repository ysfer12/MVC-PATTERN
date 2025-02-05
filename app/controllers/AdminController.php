<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;

class AdminController extends Controller {
    private $userModel;
    private $postModel;
    private $categoryModel;

    public function __construct() {
        if (!$this->isAdmin()) {
            $this->redirect('/');
        }
        
        $this->userModel = new User();
        $this->postModel = new Post();
        $this->categoryModel = new Category();
    }

    public function dashboard() {
        $stats = [
            'users' => count($this->userModel->all()),
            'posts' => count($this->postModel->all()),
            'categories' => count($this->categoryModel->all())
        ];
        
        $this->view('admin/dashboard', ['stats' => $stats]);
    }

    public function users() {
        $users = $this->userModel->all();
        $this->view('admin/users', ['users' => $users]);
    }
}
