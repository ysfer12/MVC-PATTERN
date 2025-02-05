<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Category extends Model {
    protected $table = 'categories';

    public function findBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPosts($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
