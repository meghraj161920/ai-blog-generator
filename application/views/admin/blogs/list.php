<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?> - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-journal-text"></i> Manage Blogs</h2>
                <div>
                    <a href="<?php echo site_url('admin/auto_generate'); ?>" class="btn btn-warning me-2">
                        <i class="bi bi-robot"></i> Auto-Generate Settings
                    </a>
                    <a href="<?php echo site_url('admin/blogs/create'); ?>" class="btn btn-primary">
                        <i class="bi bi-magic"></i> Generate New Blog
                    </a>
                </div>
            </div>
            
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php echo $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Topic</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($blogs)): foreach ($blogs as $blog): ?>
                                <tr>
                                    <td><?php echo $blog->id; ?></td>
                                    <td>
                                        <?php if ($blog->image): ?>
                                            <img src="<?php echo base_url($blog->image); ?>" width="60" height="40" class="rounded" style="object-fit:cover;">
                                        <?php else: ?>
                                            <span class="badge bg-secondary">No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($blog->title); ?></strong><br>
                                        <small class="text-muted">/blogs/detail/<?php echo $blog->slug; ?></small>
                                    </td>
                                    <td><span class="badge bg-info text-dark"><?php echo htmlspecialchars($blog->topic); ?></span></td>
                                    <td>
                                        <?php if ($blog->is_auto_generated): ?>
                                            <span class="badge bg-warning text-dark"><i class="bi bi-robot"></i> Auto</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark border">Manual</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($blog->status == 1): ?>
                                            <span class="badge bg-success"><i class="bi bi-eye"></i> Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><i class="bi bi-eye-slash"></i> Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($blog->created_at)); ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo site_url('admin/blogs/toggle_status/' . $blog->id); ?>" 
                                           class="btn btn-sm <?php echo $blog->status == 1 ? 'btn-outline-warning' : 'btn-success'; ?>">
                                            <?php echo $blog->status == 1 ? 'Deactivate' : 'Activate'; ?>
                                        </a>
                                        <a href="<?php echo site_url('admin/blogs/edit/' . $blog->id); ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                        <a href="<?php echo site_url('blogs/detail/' . $blog->slug); ?>" target="_blank" class="btn btn-sm btn-info"><i class="bi bi-box-arrow-up-right"></i></a>
                                        <a href="<?php echo site_url('admin/blogs/delete/' . $blog->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this blog?')"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr><td colspan="8" class="text-center text-muted py-4">No blogs found. Generate your first blog!</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
