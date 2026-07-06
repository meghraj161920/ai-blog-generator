# AI Blog Generator - Setup Guide

## Requirements
- XAMPP (Apache + MySQL + PHP)
- Google Gemini API Key: https://aistudio.google.com/app/apikey

## Setup Steps

### 1. Database
- Open phpMyAdmin → Create database `training_institute`
- Import `database_setup.sql`

### 2. Config Files (Edit These)
| File | What to Change |
|------|---------------|
| `application/config/database.php` | Your DB username/password |
| `application/config/config.php` | `base_url` to your site URL |
| `application/config/gemini.php` | Paste your Gemini API key |

### 3. Folder
- Copy project to `C:\xampp\htdocs\training\`
- Set `uploads/blogs` folder to Full Control (Windows)

### 4. Remove index.php from URL
- Enable `mod_rewrite` in Apache
- Create `.htaccess` file with rewrite rules

## URLs to Test

| URL | What It Does |
|-----|-------------|
| `http://localhost/training/admin/blogs` | Admin - Manage blogs |
| `http://localhost/training/admin/blogs/create` | Generate blog with AI |
| `http://localhost/training/admin/auto_generate` | Auto-generate 4 posts/month |
| `http://localhost/training/blogs` | Public blog page |

## How to Use
1. Go to Admin → Generate New Blog → Enter topic → AI writes content
2. Upload image → Save as Inactive
3. Go to Blog List → Click "Activate" → Blog goes live
4. Public page only shows active blogs

## For Auto-Generation (4 posts/month)
- Go to `admin/auto_generate`
- Select "4 Posts" → Click "Generate Now"
- Or set up Windows Task Scheduler to run weekly

Here are all the URLs to test:

---

## Admin URLs

| URL | What It Does |
|-----|-------------|
| `http://localhost/training/admin/blogs` | List all blogs (active & inactive) |
| `http://localhost/training/admin/blogs/create` | Generate new blog with AI |
| `http://localhost/training/admin/blogs/edit/1` | Edit blog ID 1 |
| `http://localhost/training/admin/blogs/toggle_status/1` | Activate/Deactivate blog ID 1 |
| `http://localhost/training/admin/blogs/delete/1` | Delete blog ID 1 |
| `http://localhost/training/admin/auto_generate` | Auto-generate dashboard & topic pool |

---

## Public URLs

| URL | What It Does |
|-----|-------------|
| `http://localhost/training/blogs` | Public blog listing (only active blogs) |
| `http://localhost/training/blogs/detail/your-slug-here` | Single blog post page |

---

## Test Order

1. First: `http://localhost/training/admin/blogs` — check your saved blog is there
2. Then: Click **"Activate"** on your blog
3. Then: `http://localhost/training/blogs` — check it appears publicly
4. Then: Click **"Read More"** — check the full blog page

**Test these and tell me which ones work!**