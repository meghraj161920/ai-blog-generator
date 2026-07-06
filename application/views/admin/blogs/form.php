<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?> - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .ai-box { background: #f8f9fa; border: 2px dashed #0d6efd; border-radius: 10px; padding: 30px; text-align: center; }
        .loading { display: none; }
        .content-preview { max-height: 400px; overflow-y: auto; border: 1px solid #dee2e6; padding: 15px; border-radius: 5px; background: #fff; }
    </style>
</head>
<body class="bg-light">

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-magic"></i> <?php echo $title; ?></h2>
                <a href="<?php echo site_url('admin/blogs'); ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
            
            <?php if (!empty($blog)): ?>
                <!-- EDIT MODE -->
                <form action="<?php echo site_url('admin/blogs/save'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $blog->id; ?>">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white"><i class="bi bi-pencil-square"></i> Edit Blog</div>
                        <div class="card-body">
                            <?php $this->load->view('admin/blogs/form_fields', ['blog' => $blog]); ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Update Blog</button>
                        </div>
                    </div>
                </form>
            <?php else: ?>
                <!-- CREATE MODE: AI Generation -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white"><i class="bi bi-lightning-charge"></i> Step 1: Generate with AI</div>
                            <div class="card-body">
                                <div class="ai-box">
                                    <i class="bi bi-robot display-4 text-primary mb-3"></i>
                                    <h5>Enter Blog Topic</h5>
                                    <p class="text-muted small">Gemini AI will write the full blog</p>
                                    <input type="text" id="topicInput" class="form-control mb-3" placeholder="e.g. How to Learn Python">
                                    <button type="button" id="generateBtn" class="btn btn-primary w-100"><i class="bi bi-magic"></i> Generate Blog</button>
                                    <div class="loading mt-3">
                                        <div class="spinner-border text-primary" role="status"></div>
                                        <p class="text-muted mt-2">AI is writing... (10-30 seconds)</p>
                                    </div>
                                </div>
                                <div id="generateError" class="alert alert-danger mt-3" style="display:none;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <form action="<?php echo site_url('admin/blogs/save'); ?>" method="post" enctype="multipart/form-data" id="blogForm">
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white"><i class="bi bi-check-circle"></i> Step 2: Review, Add Image & Save</div>
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle"></i> Blog will be saved as <strong>Inactive</strong>. Activate it later.
                                    </div>
                                    <?php $this->load->view('admin/blogs/form_fields'); ?>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-save"></i> Save Blog (Inactive)</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#generateBtn').click(function() {
        var topic = $('#topicInput').val().trim();
        if (!topic) { alert('Please enter a topic!'); return; }
        
        $('.loading').show();
        $('#generateBtn').prop('disabled', true);
        $('#generateError').hide();
        
        $.ajax({
            url: '<?php echo site_url("admin/blogs/generate_ai"); ?>',
            type: 'POST',
            data: { topic: topic },
            dataType: 'json',
            success: function(response) {
                $('.loading').hide();
                $('#generateBtn').prop('disabled', false);
                
                if (response.success) {
                    var d = response.data;
                    $('#title').val(d.title);
                    $('#slug').val(d.slug);
                    $('#meta_description').val(d.meta_description);
                    $('#meta_keywords').val(d.meta_keywords);
                    $('#content').val(d.content);
                    $('#topic').val(d.topic);
                    $('#contentPreview').html(d.content);
                    
                    $('html, body').animate({ scrollTop: $('#blogForm').offset().top - 20 }, 500);
                } else {
                    $('#generateError').text(response.error).show();
                }
            },
            error: function() {
                $('.loading').hide();
                $('#generateBtn').prop('disabled', false);
                $('#generateError').text('Failed to connect to AI.').show();
            }
        });
    });
});
</script>

</body>
</html>
