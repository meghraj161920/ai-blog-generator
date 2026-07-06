<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog->title); ?> - Training Institute</title>
    <meta name="description" content="<?php echo htmlspecialchars($blog->meta_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($blog->meta_keywords); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .blog-header { background: #f8f9fa; padding: 40px 0; border-bottom: 1px solid #dee2e6; }
        .blog-content h2 { color: #0d6efd; margin-top: 30px; margin-bottom: 15px; font-size: 1.6rem; }
        .blog-content h3 { color: #495057; margin-top: 25px; margin-bottom: 12px; font-size: 1.3rem; }
        .blog-content p { line-height: 1.8; color: #333; margin-bottom: 15px; }
        .blog-content ul { margin-bottom: 15px; }
        .blog-content li { margin-bottom: 8px; }
        .blog-img { width: 100%; max-height: 450px; object-fit: cover; border-radius: 10px; }
    </style>
</head>
<body>

<!-- Blog Header -->
<section class="blog-header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <span class="badge bg-primary mb-3"><?php echo htmlspecialchars($blog->topic); ?></span>
                <h1 class="display-5 fw-bold mb-3"><?php echo htmlspecialchars($blog->title); ?></h1>
                <div class="text-muted">
                    <i class="bi bi-calendar"></i> <?php echo date('F d, Y', strtotime($blog->created_at)); ?>
                    <span class="mx-2">|</span>
                    <i class="bi bi-clock"></i> <?php echo ceil(str_word_count(strip_tags($blog->content)) / 200); ?> min read
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Content -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <?php if ($blog->image): ?>
                <img src="<?php echo base_url($blog->image); ?>" class="blog-img mb-4 shadow-sm" alt="<?php echo htmlspecialchars($blog->title); ?>">
            <?php endif; ?>
            
            <div class="blog-content">
                <?php echo $blog->content; ?>
            </div>
            
            <hr class="my-5">
            
            <div class="d-flex justify-content-between align-items-center">
                <a href="<?php echo site_url('blogs'); ?>" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Back to All Blogs
                </a>
                <div class="text-muted small">
                    <i class="bi bi-tag"></i> <?php echo htmlspecialchars($blog->meta_keywords); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
