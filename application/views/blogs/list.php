<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Training Institute</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .blog-card { transition: transform 0.2s; height: 100%; }
        .blog-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .blog-img { height: 220px; object-fit: cover; width: 100%; }
        .hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 60px 0; }
    </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero text-center">
    <div class="container">
        <h1 class="display-4 fw-bold"><i class="bi bi-journal-richtext"></i> Our Blog</h1>
        <p class="lead">Latest insights, tutorials, and updates from our institute</p>
    </div>
</section>

<!-- Blog Grid -->
<div class="container py-5">
    <div class="row g-4">
        <?php if (!empty($blogs)): foreach ($blogs as $blog): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card blog-card">
                <?php if ($blog->image): ?>
                    <img src="<?php echo base_url($blog->image); ?>" class="card-img-top blog-img" alt="<?php echo htmlspecialchars($blog->title); ?>">
                <?php else: ?>
                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:220px;">
                        <i class="bi bi-image display-4"></i>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <span class="badge bg-primary mb-2"><?php echo htmlspecialchars($blog->topic); ?></span>
                    <h5 class="card-title"><?php echo htmlspecialchars($blog->title); ?></h5>
                    <p class="card-text text-muted small">
                        <?php echo character_limiter(strip_tags($blog->meta_description), 120); ?>
                    </p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            <i class="bi bi-calendar"></i> <?php echo date('M d, Y', strtotime($blog->created_at)); ?>
                        </small>
                        <a href="<?php echo site_url('blogs/detail/' . $blog->slug); ?>" class="btn btn-outline-primary btn-sm">
                            Read More <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; else: ?>
        <div class="col-12 text-center py-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <h3 class="text-muted mt-3">No blogs published yet</h3>
            <p class="text-muted">Check back soon for new content!</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
