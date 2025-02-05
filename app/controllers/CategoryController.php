<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;

class CategoryController extends Controller {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function index() {
        $categories = $this->categoryModel->all();
        $this->view('admin/categories/index', ['categories' => $categories]);
    }

    public function store() {
        if (!$this->isAdmin()) {
            $this->redirect('/');
        }

        $categoryData = [
            'name' => $this->getPost('name'),
            'slug' => $this->createSlug($this->getPost('name'))
        ];

        $this->categoryModel->create($categoryData);
        $this->redirect('/admin/categories');
    }

    private function createSlug($name) {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }
}