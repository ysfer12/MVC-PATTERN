<div class="container">
    <div class="card mb-4">
        <div class="card-body">
            <h1 class="card-title"><?= htmlspecialchars($post['title']) ?></h1>
            <p class="text-muted">
                By <?= htmlspecialchars($post['author_name']) ?> 
                in <?= htmlspecialchars($post['category_name']) ?>
            </p>
            <div class="card-text">
                <?= nl2br(htmlspecialchars($post['content'])) ?>
            </div>

            <?php if (isset($_SESSION['user_id']) && 
                     ($_SESSION['user_id'] == $post['user_id'] || 
                      $_SESSION['user_role'] == 'admin')): ?>
                <div class="mt-3">
                    <!-- Edit Button -->
                    <a href="/mvc_new/public/posts/<?= $post['id'] ?>/edit" 
                       class="btn btn-primary">Edit</a>
                    
                    <!-- Delete Button -->
                    <form action="/mvc_new/public/posts/<?= $post['id'] ?>/delete" 
                          method="POST" class="d-inline">
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="card">
        <div class="card-header">Comments</div>
        <div class="card-body">
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Add Comment Form -->
                <form action="/mvc_new/public/comments" method="POST" class="mb-4">
                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                    <div class="mb-3">
                        <textarea name="content" class="form-control" rows="3" 
                                required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                </form>
            <?php endif; ?>

            <!-- Display Comments -->
            <?php foreach ($comments as $comment): ?>
                <div class="mb-3">
                    <h6><?= htmlspecialchars($comment['author_name']) ?></h6>
                    <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                    <?php if (isset($_SESSION['user_id']) && 
                             ($_SESSION['user_id'] == $comment['user_id'] || 
                              $_SESSION['user_role'] == 'admin')): ?>
                        <form action="/mvc_new/public/comments/<?= $comment['id'] ?>" 
                              method="POST" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-danger">
                                Delete
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>