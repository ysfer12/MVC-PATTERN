<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?= $title ?? 'Blog CMS' ?></title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
       <div class="container">
       <a class="navbar-brand" href="/mvc_new/public">Blog CMS</a>
       <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
               <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="navbarNav">
               <ul class="navbar-nav me-auto">
                   <li class="nav-item">
                       <a class="nav-link" href="/mvc_new/public/posts">Posts</a>
                   </li>
                   <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                       <li class="nav-item">
                           <a class="nav-link" href="/mvc_new/public/admin/dashboard">Admin</a>
                       </li>
                   <?php endif; ?>
               </ul>
               <ul class="navbar-nav">
                   <?php if (isset($_SESSION['user_id'])): ?>
                       <li class="nav-item">
                           <a class="nav-link" href="/mvc_new/public/posts/create">New Post</a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link" href="/mvc_new/public/logout">Logout</a>
                       </li>
                   <?php else: ?>
                       <li class="nav-item">
                           <a class="nav-link" href="/mvc_new/public/login">Login</a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link" href="/mvc_new/public/register">Register</a>
                       </li>
                   <?php endif; ?>
               </ul>
           </div>
       </div>
   </nav>

   <main class="container my-4">
       <?php if (isset($content)): ?>
           <?php echo $content; ?>
       <?php else: ?>
           <div class="alert alert-danger">No content to display</div>
       <?php endif; ?>
   </main>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <script src="/assets/js/script.js"></script>
</body>
</html>