<div class="row">
    <div class="col-md-8">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title"><?= htmlspecialchars($post['title']) ?></h2>
                        <p class="card-text"><?= substr(htmlspecialchars($post['content']), 0, 200) ?>...</p>
                        <a href="/mvc_new/public/posts/<?= $post['id'] ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">No posts found.</div>
        <?php endif; ?>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Categories</div>
            <div class="card-body">
                <?php if (!empty($categories)): ?>
                    <ul class="list-unstyled">
                        <?php foreach ($categories as $category): ?>
                            <li>
                                <a href="/mvc_new/public/categories/<?= $category['slug'] ?>">
                                    <?= htmlspecialchars($category['name']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No categories found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>