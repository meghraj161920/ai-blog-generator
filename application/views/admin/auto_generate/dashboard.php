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
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2><i class="bi bi-robot"></i> Auto-Generate Settings</h2>
                <a href="<?php echo site_url('admin/blogs'); ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back to Blogs</a>
            </div>
        </div>
        
        <!-- Left Column: Generate & Cron -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4 border-primary">
                <div class="card-header bg-primary text-white"><i class="bi bi-lightning-charge"></i> Auto-Generate Posts</div>
                <div class="card-body">
                    <p class="text-muted">Generate multiple blog posts at once using AI. They will be saved as <strong>inactive</strong> drafts.</p>
                    <div class="mb-3">
                        <label class="form-label">How many posts to generate?</label>
                        <select id="generateCount" class="form-select">
                            <option value="1">1 Post</option>
                            <option value="2">2 Posts</option>
                            <option value="4" selected>4 Posts (1 month)</option>
                            <option value="8">8 Posts (2 months)</option>
                            <option value="10">10 Posts</option>
                        </select>
                    </div>
                    <button type="button" id="btnAutoGenerate" class="btn btn-primary w-100">
                        <i class="bi bi-magic"></i> Generate Now
                    </button>
                    
                    <div id="autoGenLoading" class="text-center mt-3" style="display:none;">
                        <div class="spinner-border text-primary"></div>
                        <p class="text-muted mt-2">Generating posts... This may take a few minutes.</p>
                    </div>
                    <div id="autoGenResults" class="mt-3"></div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white"><i class="bi bi-terminal"></i> Cron Job Setup</div>
                <div class="card-body">
                    <p class="small text-muted">For automatic weekly generation (1 post/week = 4/month), add this to your crontab:</p>
                    <code class="d-block bg-dark text-light p-2 rounded small" style="font-size:0.8rem;">
                        0 2 * * 0 cd /var/www/html/training && php index.php cli auto_generate 1 >> /var/log/training_auto.log 2>&1
                    </code>
                    <p class="small text-muted mt-2">This runs every Sunday at 2 AM and generates 1 post.</p>
                </div>
            </div>
        </div>
        
        <!-- Right Column: Topic Pool & Logs -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white"><i class="bi bi-collection"></i> Topic Pool (Auto-Generation picks from here)</div>
                <div class="card-body">
                    <form action="<?php echo site_url('admin/auto_generate/add_topic'); ?>" method="post" class="row g-2 mb-3">
                        <div class="col-md-6">
                            <input type="text" name="topic" class="form-control" placeholder="Enter a topic..." required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="category" class="form-control" placeholder="Category (optional)">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success w-100"><i class="bi bi-plus"></i> Add Topic</button>
                        </div>
                    </form>
                    
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr><th>Topic</th><th>Category</th><th>Actions</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($topics as $t): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($t->topic); ?></td>
                                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($t->category); ?></span></td>
                                    <td>
                                        <a href="<?php echo site_url('admin/auto_generate/delete_topic/' . $t->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remove this topic?')"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white"><i class="bi bi-clock-history"></i> Recent Generation Logs</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr><th>Date</th><th>Topic</th><th>Status</th><th>Blog ID</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td><?php echo date('M d, H:i', strtotime($log->created_at)); ?></td>
                                    <td><?php echo htmlspecialchars($log->topic); ?></td>
                                    <td>
                                        <?php if ($log->status == 'success'): ?>
                                            <span class="badge bg-success">Success</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Failed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $log->blog_id ? $log->blog_id : '-'; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#btnAutoGenerate').click(function() {
    var count = $('#generateCount').val();
    if (!confirm('Generate ' + count + ' blog post(s)? They will be saved as inactive drafts.')) return;
    
    $('#btnAutoGenerate').prop('disabled', true);
    $('#autoGenLoading').show();
    $('#autoGenResults').html('');
    
    $.ajax({
        url: '<?php echo site_url("admin/auto_generate/generate_now"); ?>',
        type: 'POST',
        data: { count: count },
        dataType: 'json',
        success: function(res) {
            $('#btnAutoGenerate').prop('disabled', false);
            $('#autoGenLoading').hide();
            
            var html = '<div class="alert alert-info"><h6>Results:</h6><ul class="mb-0">';
            $.each(res.results, function(i, r) {
                if (r.success) {
                    html += '<li class="text-success">✅ <strong>' + r.title + '</strong> (ID: ' + r.id + ')</li>';
                } else {
                    html += '<li class="text-danger">❌ ' + r.topic + ' — ' + r.error + '</li>';
                }
            });
            html += '</ul></div>';
            $('#autoGenResults').html(html);
        },
        error: function() {
            $('#btnAutoGenerate').prop('disabled', false);
            $('#autoGenLoading').hide();
            $('#autoGenResults').html('<div class="alert alert-danger">Request failed. Try again.</div>');
        }
    });
});
</script>

</body>
</html>
