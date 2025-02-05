<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Comment;

class CommentController extends Controller {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new Comment();
    }

    public function store() {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }

        $commentData = [
            'post_id' => $this->getPost('post_id'),
            'user_id' => $_SESSION['user_id'],
            'content' => $this->getPost('content')
        ];

        $this->commentModel->create($commentData);
        $this->redirect("/posts/{$commentData['post_id']}");
    }

    public function delete($params) {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }

        $comment = $this->commentModel->find($params['id']);
        if ($comment['user_id'] == $_SESSION['user_id'] || $this->isAdmin()) {
            $this->commentModel->delete($params['id']);
        }

        $this->redirect("/posts/{$comment['post_id']}");
    }
}
