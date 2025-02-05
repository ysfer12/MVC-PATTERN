<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller {
   private $userModel;
   private $basePath = '/mvc_new/public'; // Add base path

   public function __construct() {
       $this->userModel = new User();
   }

   public function login() {
       // If already logged in, redirect to home
       if (isset($_SESSION['user_id'])) {
           $this->redirect($this->basePath);
       }
       $this->view('auth/login', [
           'title' => 'Login'
       ]);
   }

   public function authenticate() {
       $email = $this->getPost('email');
       $password = $this->getPost('password');

       // Validate input
       $errors = [];
       if (empty($email)) {
           $errors[] = 'Email is required';
       }
       if (empty($password)) {
           $errors[] = 'Password is required';
       }

       if (!empty($errors)) {
           return $this->view('auth/login', [
               'errors' => $errors,
               'title' => 'Login'
           ]);
       }

       // Find user
       $user = $this->userModel->findByEmail($email);
       
       // Verify password
       if ($user && password_verify($password, $user['password'])) {
           // Set session
           $_SESSION['user_id'] = $user['id'];
           $_SESSION['user_role'] = $user['role'];
           $_SESSION['user_name'] = $user['name'];
           
           $this->redirect($this->basePath);
       } else {
           return $this->view('auth/login', [
               'errors' => ['Invalid email or password'],
               'title' => 'Login'
           ]);
       }
   }

   public function register() {
       if (isset($_SESSION['user_id'])) {
           $this->redirect($this->basePath);
       }
       $this->view('auth/register', [
           'title' => 'Register'
       ]);
   }

   public function store() {
       $name = $this->getPost('name');
       $email = $this->getPost('email');
       $password = $this->getPost('password');
       $confirmPassword = $this->getPost('confirm_password');

       // Validate input
       $errors = [];
       if (empty($name)) {
           $errors[] = 'Name is required';
       }
       if (empty($email)) {
           $errors[] = 'Email is required';
       } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           $errors[] = 'Invalid email format';
       }
       if (empty($password)) {
           $errors[] = 'Password is required';
       } elseif (strlen($password) < 6) {
           $errors[] = 'Password must be at least 6 characters';
       }
       if ($password !== $confirmPassword) {
           $errors[] = 'Passwords do not match';
       }

       if (!empty($errors)) {
           return $this->view('auth/register', [
               'errors' => $errors,
               'old' => [
                   'name' => $name,
                   'email' => $email
               ],
               'title' => 'Register'
           ]);
       }

       // Check if email exists
       if ($this->userModel->findByEmail($email)) {
           return $this->view('auth/register', [
               'errors' => ['Email already exists'],
               'old' => [
                   'name' => $name,
                   'email' => $email
               ],
               'title' => 'Register'
           ]);
       }

       // Create user
       $userData = [
           'name' => $name,
           'email' => $email,
           'password' => password_hash($password, PASSWORD_DEFAULT),
           'role' => 'user'
       ];

       $userId = $this->userModel->create($userData);

       if ($userId) {
           $_SESSION['user_id'] = $userId;
           $_SESSION['user_role'] = 'user';
           $_SESSION['user_name'] = $name;
           
           $this->redirect($this->basePath);
       } else {
           return $this->view('auth/register', [
               'errors' => ['Registration failed. Please try again.'],
               'old' => [
                   'name' => $name,
                   'email' => $email
               ],
               'title' => 'Register'
           ]);
       }
   }

   public function logout() {
       // Destroy session
       session_unset();
       session_destroy();
       
       // Redirect to login page
       $this->redirect($this->basePath . '/login');
   }

   public function forgotPassword() {
       $this->view('auth/forgot-password', [
           'title' => 'Forgot Password'
       ]);
   }

   private function validateEmail($email) {
       return filter_var($email, FILTER_VALIDATE_EMAIL);
   }

   private function validatePassword($password) {
       // Password must be at least 6 characters
       return strlen($password) >= 6;
   }
}