<?php $blog = isset($blog) ? $blog : null; ?>

<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label fw-bold">Blog Title</label>
            <input type="text" name="title" id="title" class="form-control form-control-lg" 
                   value="<?php echo $blog ? htmlspecialchars($blog->title) : ''; ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">URL Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" 
                   value="<?php echo $blog ? htmlspecialchars($blog->slug) : ''; ?>" required>
            <div class="form-text">URL: yoursite.com/blogs/detail/<strong>slug</strong></div>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Topic</label>
            <input type="text" name="topic" id="topic" class="form-control" 
                   value="<?php echo $blog ? htmlspecialchars($blog->topic) : ''; ?>">
        </div>
        
        <div class="mb-3">
            <label class="form-label fw-bold">Content (HTML)</label>
            <textarea name="content" id="content" rows="12" class="form-control" required><?php echo $blog ? htmlspecialchars($blog->content) : ''; ?></textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Preview</label>
            <div id="contentPreview" class="content-preview">
                <?php echo $blog ? $blog->content : '<span class="text-muted">Preview appears here...</span>'; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label fw-bold">Blog Image</label>
            <?php if ($blog && $blog->image): ?>
                <div class="mb-2">
                    <img src="<?php echo base_url($blog->image); ?>" class="img-fluid rounded border" alt="Current">
                </div>
            <?php endif; ?>
            <input type="file" name="blog_image" class="form-control" accept="image/*">
            <div class="form-text">Upload image (JPG, PNG, WEBP). Max 2MB.</div>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Meta Description</label>
            <textarea name="meta_description" id="meta_description" rows="3" class="form-control" maxlength="160"><?php echo $blog ? htmlspecialchars($blog->meta_description) : ''; ?></textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Meta Keywords</label>
            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" 
                   value="<?php echo $blog ? htmlspecialchars($blog->meta_keywords) : ''; ?>">
        </div>
        
        <?php if ($blog): ?>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <div>
                <?php if ($blog->status == 1): ?>
                    <span class="badge bg-success fs-6"><i class="bi bi-eye"></i> Active (Live)</span>
                <?php else: ?>
                    <span class="badge bg-warning text-dark fs-6"><i class="bi bi-eye-slash"></i> Inactive (Draft)</span>
                <?php endif; ?>
            </div>
            <div class="form-text mt-2">Use the list page to toggle status.</div>
        </div>
        <?php else: ?>
        <div class="alert alert-warning">
            <i class="bi bi-eye-slash"></i> <strong>Status:</strong> Inactive<br>
            <small>This blog will be saved as a draft. Activate it from the list page when ready.</small>
        </div>
        <?php endif; ?>
    </div>
</div>
