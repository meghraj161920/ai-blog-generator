
```markdown
# 🤖 AI Blog Generator — CodeIgniter 3 Module

> 🎯 An AI-powered blog system that automatically generates SEO-friendly blog posts using **Google Gemini AI**, with a complete **Draft → Publish** workflow.

---

## 🛠️ Tech Stack

| Technology | Purpose |
|:----------:|:--------|
| 🐘 **CodeIgniter 3** | PHP Framework |
| 🎨 **Bootstrap 5** | Frontend Styling |
| 🧠 **Google Gemini AI** | Content Generation |
| 🗄️ **MySQL** | Database |
| ⚡ **jQuery + AJAX** | Dynamic UI |
| 🌐 **Apache + mod_rewrite** | Web Server |

---

## 📋 Requirements

| Software | Link |
|:--------:|:----:|
| 🖥️ **XAMPP** (Apache + MySQL + PHP) | [Download](https://www.apachefriends.org) |
| 🔑 **Google Gemini API Key** | [Get Key](https://aistudio.google.com/app/apikey) |

---

## 🚀 Setup Steps

### 1️⃣ Database Setup

```bash
# Open phpMyAdmin → Create database
CREATE DATABASE training_institute;
```

📥 **Import:** `database_setup.sql` file into the database

---

### 2️⃣ Config Files (Edit These)

| ⚙️ File | 📝 What to Change |
|:--------|:------------------|
| `application/config/database.php` | 🔐 Your DB username & password |
| `application/config/config.php` | 🌐 `base_url` to your site URL |
| `application/config/gemini.php` | 🔑 Paste your Gemini API key |

---

### 3️⃣ Folder Setup

```bash
📁 Copy project to: C:\xampp\htdocs\training\
🔓 Set uploads/blogs folder to: Full Control (Windows)
```

---

### 4️⃣ Remove index.php from URL

```apache
# Enable mod_rewrite in Apache
# Create .htaccess file with:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

---

## 🔗 URLs to Test

### 🛡️ Admin URLs

| 🌐 URL | 📖 What It Does |
|:-------|:----------------|
| `/admin/blogs` | 📋 List all blogs (active & inactive) |
| `/admin/blogs/create` | ✨ Generate new blog with AI |
| `/admin/blogs/edit/1` | ✏️ Edit blog ID 1 |
| `/admin/blogs/toggle_status/1` | 🔄 Activate/Deactivate blog |
| `/admin/blogs/delete/1` | 🗑️ Delete blog |
| `/admin/auto_generate` | 🤖 Auto-generate dashboard & topic pool |

---

### 🌍 Public URLs

| 🌐 URL | 📖 What It Does |
|:-------|:----------------|
| `/blogs` | 📰 Public blog listing (only active) |
| `/blogs/detail/your-slug` | 📄 Single blog post page |

---

## 🎮 How to Use

| Step | Action |
|:----:|:-------|
| 1️⃣ | Go to **Admin → Generate New Blog** |
| 2️⃣ | Enter topic → Click **"Generate with AI"** 🤖 |
| 3️⃣ | Review content → **Upload image** 📤 |
| 4️⃣ | Click **"Save Blog (Inactive)"** 💾 |
| 5️⃣ | Go to **Blog List → Click "Activate"** ✅ |
| 6️⃣ | Blog is now **live** on public page! 🚀 |

---

## ⚡ Auto-Generation (4 Posts/Month)

| Option | How |
|:-------|:----|
| 🖱️ **Manual** | Go to `admin/auto_generate` → Select "4 Posts" → Click "Generate Now" |
| ⏰ **Scheduled** | Set up Windows Task Scheduler to run weekly |

---

## 🧩 Challenges Faced & Solutions

### 1️⃣ PHP 8.x Compatibility
❌ **Problem:** CI3 built for PHP 7.x, deprecation warnings flooded the page
✅ **Solution:** Set `error_reporting(E_ALL & ~E_DEPRECATED)` in config

### 2️⃣ Session Library Missing
❌ **Problem:** `set_flashdata() on null` — session not loaded
✅ **Solution:** Added `$this->load->library('session')` to controllers

### 3️⃣ URL Rewriting (404 Errors)
❌ **Problem:** `.htaccess` not read, `AllowOverride None` in Apache
✅ **Solution:** Added `<Directory>` block with `AllowOverride All`

### 4️⃣ Missing Text Helper
❌ **Problem:** `character_limiter()` undefined
✅ **Solution:** Added `'text'` to `autoload['helper']`

### 5️⃣ Slugs with Spaces
❌ **Problem:** AI-generated slugs like `Quas error eaque eiu` broke URLs
✅ **Solution:** Fixed `create_slug()` to replace spaces with hyphens

### 6️⃣ Gemini API Quota
❌ **Problem:** HTTP 429 — free tier quota exceeded
✅ **Solution:** Added `sleep(2)` delays + topic pool system

### 7️⃣ File Permissions
❌ **Problem:** VS Code couldn't save, owned by `www-data`
✅ **Solution:** `chown -R $USER:$USER` + `chmod 777 uploads`

### 8️⃣ Database Connection
❌ **Problem:** Wrong credentials in `database.php`
✅ **Solution:** Created dedicated MySQL user with proper privileges

---

## ⚠️ IMPORTANT

| 🔔 Note | 💡 Details |
|:--------|:-----------|
| 🔐 **Never share API keys** | Keep `gemini.php` private |
| 🔓 **Uploads folder** | Must be writable for images |
| 👁️ **Inactive by default** | All AI blogs start as drafts |
| 🗑️ **Excluded from zip** | `system/`, `user_guide/`, logs, cache |

---

## ✨ Features Built

| ✅ Feature | Description |
|:----------|:------------|
| 🤖 AI Blog Generation | Topic → Full blog post with HTML formatting |
| 🖼️ Manual Image Upload | You provide the blog image |
| 💾 Draft → Publish | Save inactive, activate when ready |
| 🎲 Topic Pool | Manage topics for auto-generation |
| 📊 Generation Logs | Track success/failure of auto-posts |
| 🔍 SEO Ready | Meta description, keywords, slug |
| 📱 Responsive | Bootstrap 5 mobile-friendly design |
| ⏰ Cron Ready | CLI controller for scheduled generation |

---

## 📞 Support

For issues or questions, contact the developer.

---

<p align="center">
  <b>Built with 💙 using CodeIgniter 3, Bootstrap 5 & Google Gemini AI</b>
</p>

