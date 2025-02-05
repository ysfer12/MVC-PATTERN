<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model {
    protected $table = 'users';

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getPosts($userId) {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}