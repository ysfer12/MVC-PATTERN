<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller {
   private $postModel;
   private $categoryModel;

   public function __construct() {
       $this->postModel = new Post();
       $this->categoryModel = new Category();
   }

   public function index() {
       $page = $this->getQuery('page', 1);
       $limit = 10;
       $offset = ($page - 1) * $limit;
       
       $posts = $this->postModel->paginate($limit, $offset);
       $categories = $this->categoryModel->all();
       
       $this->view('posts/index', [
           'posts' => $posts,
           'categories' => $categories,
           'title' => 'Blog Posts'
       ]);
   }

   public function show($params) {
    $id = $params['id'] ?? null;
    if (!$id) {
        $this->redirect('/posts');
    }

    $post = $this->postModel->findWithAuthor($id);
    if (!$post) {
        $this->redirect('/posts');
    }

    $comments = $this->postModel->getComments($id);
    
    $this->view('posts/show', [
        'post' => $post,
        'comments' => $comments,
        'isOwner' => isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id'],
        'isAdmin' => isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'
    ]);
}

   public function create() {
       if (!$this->isAuthenticated()) {
           $this->redirect('/login');
       }
       
       $categories = $this->categoryModel->all();
       $this->view('posts/create', [
           'categories' => $categories,
           'title' => 'Create New Post'
       ]);
   }

   public function store() {
    if (!$this->isAuthenticated()) {
        $this->redirect('/mvc_new/public/login');
    }

    $postData = [
        'title' => $this->getPost('title'),
        'content' => $this->getPost('content'),
        'category_id' => $this->getPost('category_id'),
        'user_id' => $_SESSION['user_id'],
        'slug' => $this->createSlug($this->getPost('title')),
        'status' => 'published'
    ];

    $postId = $this->postModel->create($postData);
    
    if ($postId) {
        $this->redirect('/mvc_new/public/posts');
    } else {
        $categories = $this->categoryModel->all();
        return $this->view('posts/create', [
            'categories' => $categories,
            'errors' => ['Failed to create post']
        ]);
    }
}

private function createSlug($title) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    return $slug;
}

public function edit($params) {
    if (!$this->isAuthenticated()) {
        $this->redirect('/mvc_new/public/login');
    }

    $id = $params['id'] ?? null;
    if (!$id) {
        $this->redirect('/mvc_new/public/posts');
    }

    $post = $this->postModel->find($id);
    if (!$post) {
        $this->redirect('/mvc_new/public/posts');
    }

    // Check if user is author or admin
    if ($post['user_id'] != $_SESSION['user_id'] && 
        (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin')) {
        $this->redirect('/mvc_new/public/posts');
    }

    $categories = $this->categoryModel->all();
    $this->view('posts/edit', [
        'post' => $post,
        'categories' => $categories,
        'title' => 'Edit Post'
    ]);
}
public function update($params) {
    if (!$this->isAuthenticated()) {
        $this->redirect('/mvc_new/public/login');
    }

    $id = $params['id'] ?? null;
    if (!$id) {
        $this->redirect('/mvc_new/public/posts');
    }

    $post = $this->postModel->find($id);
    if (!$post) {
        $this->redirect('/mvc_new/public/posts');
    }

    // Check if user is author or admin
    if ($post['user_id'] != $_SESSION['user_id'] && 
        (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin')) {
        $this->redirect('/mvc_new/public/posts');
    }

    $postData = [
        'title' => $this->getPost('title'),
        'content' => $this->getPost('content'),
        'category_id' => $this->getPost('category_id'),
        'slug' => $this->createSlug($this->getPost('title'))
    ];

    if ($this->postModel->update($id, $postData)) {
        $this->redirect("/mvc_new/public/posts/{$id}");
    } else {
        $categories = $this->categoryModel->all();
        return $this->view('posts/edit', [
            'post' => $post,
            'categories' => $categories,
            'errors' => ['Failed to update post'],
            'title' => 'Edit Post'
        ]);
    }
}

   public function delete($params) {
       if (!$this->isAuthenticated()) {
           $this->redirect('/login');
       }

       $id = $params['id'] ?? null;
       if (!$id) {
           $this->redirect('/posts');
       }

       $post = $this->postModel->find($id);
       if (!$post) {
           $this->redirect('/posts');
       }

       // Check if user owns the post or is admin
       if ($post['user_id'] != $_SESSION['user_id'] && 
           (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin')) {
           $this->redirect('/posts');
       }

       $this->postModel->delete($id);
       $this->redirect('/posts');
   }

   private function validatePost($data) {
       $errors = [];

       if (empty($data['title'])) {
           $errors['title'] = 'Title is required';
       } elseif (strlen($data['title']) < 5) {
           $errors['title'] = 'Title must be at least 5 characters';
       }

       if (empty($data['content'])) {
           $errors['content'] = 'Content is required';
       } elseif (strlen($data['content']) < 10) {
           $errors['content'] = 'Content must be at least 10 characters';
       }

       if (empty($data['category_id'])) {
           $errors['category_id'] = 'Category is required';
       }

       return $errors;
   }
}