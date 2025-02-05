<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Comment extends Model {
    protected $table = 'comments';

    public function findWithAuthor($id) {
        $sql = "SELECT c.*, u.name as author_name 
                FROM {$this->table} c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByPost($postId) {
        $sql = "SELECT c.*, u.name as author_name 
                FROM {$this->table} c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.post_id = ? 
                ORDER BY c.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}