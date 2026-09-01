# Aurora Library — Library Management System

A premium, modern Library Management System built with PHP and MySQL, featuring a sophisticated vanilla CSS/JS design system ("Aurora") for a refined, editorial aesthetic. Administrators manage books, categories, authors, and book issuing through an elegant control center, while members enjoy a personalized portal to view issued books and manage their profiles.

---

## ✨ Highlights

- **Premium UI** — Custom design system with champagne-gold + midnight-ink palette, Playfair Display editorial headlines, and Inter for body text. No Bootstrap dependency.
- **Glassmorphism** — Frosted-glass navigation, layered radial gradients, and drifting SVG patterns on auth screens.
- **Smooth animations** — Staggered fade-up reveals, animated stat counters, button shimmer, toast notifications, and password visibility toggles.
- **Responsive** — Adaptive sidebar, fluid grid layouts, and mobile-friendly navigation.
- **Zero build step** — Drop into any PHP/MySQL host and run.

---

## 🚀 Features

### Admin Console
- **Dashboard** — Animated stat tiles (total users, books, categories, issued books) plus system status panel and quick-action shortcuts
- **Book Management** — Add, edit, delete, and browse the full book catalog
- **Category Management** — Add, edit, delete, and list book categories
- **Author Management** — Issue-book form pulls authors from the `authors` table
- **Book Issuing** — Issue books to registered members; auto-confirm via toast
- **Member Management** — Browse all registered users with a live search filter
- **Issued Books** — View all books currently on loan with member info
- **Profile Management** — View, edit, and change password with validation
- **One-time setup script** — `create_admin.php` seeds the database and creates the first admin

### Member Portal
- **Dashboard** — Personalized welcome, issued-book counter, daily quote
- **My Books** — Live-searchable list of currently issued titles
- **Profile Management** — View, edit, and change password
- **Self-service signup** — Create a free account with email & password

### UX Polish
- Toast notifications for every success/error
- Confirmation prompts on destructive actions
- Loading state on form submission (spinner button)
- Inline error messages on login failure
- Empty-state placeholders ("∅") on tables
- Auto-highlighted active link in sidebar (gold pill)
- Password show/hide toggle

---

## 🛠️ Technology Stack

| Layer | Technology |
|-------|------------|
| **Backend** | PHP 7.0+ (uses MySQLi extension) |
| **Database** | MySQL 5.6+ |
| **Frontend** | Vanilla HTML5, CSS3, JavaScript (ES5+) |
| **Typography** | Playfair Display, Inter, JetBrains Mono (Google Fonts) |
| **Icons** | Inline SVG (Feather-style) |
| **Server** | Apache / Nginx (tested on Apache 2.4.58) |
| **PHP Tested** | 8.2.12 |

> **No frameworks.** No Bootstrap, no jQuery, no build pipeline. The entire design system lives in two files: `aurora.css` (~600 lines) and `aurora.js`.

---

## 🗄️ Database Schema

Database name: **`lms`**

| Table | Columns |
|-------|---------|
| `admins` | `id`, `name`, `email` (UNIQUE), `password`, `mobile` |
| `users` | `id`, `name`, `email` (UNIQUE), `password`, `mobile`, `address` |
| `books` | `book_id`, `book_name`, `author_id`, `cat_id`, `book_no`, `book_price` |
| `authors` | `author_id`, `author_name` |
| `category` | `cat_id`, `cat_name` |
| `issued_books` | `id`, `book_no`, `book_name`, `book_author`, `student_id`, `status`, `issue_date` |

> The `lms` database and all six tables are created automatically when you run `create_admin.php`.

---

## 📁 Project Structure

```
lms/
├── aurora.css                    # Design system (colors, typography, components, animations)
├── aurora.js                     # Shared interactions (toasts, counters, table filters, password toggles)
├── create_admin.php              # One-time setup — seeds DB + creates first admin
├── logout.php                    # Session destroy + redirect
│
├── login_module/
│   ├── index.php                 # Member sign-in
│   ├── admin_login.php           # Administrator sign-in
│   ├── signup.php                # Member registration form
│   └── register.php              # Registration handler + success page
│
├── Admin_Dashboard_Module/
│   ├── sidebar.php               # Reusable admin navigation include
│   ├── functions.php             # Count helpers (get_user_count, get_book_count, etc.)
│   ├── admin_dashboard.php       # Stats overview + quick actions
│   ├── view_profile.php          # Admin profile view
│   ├── edit_profile.php          # Admin profile editor
│   ├── update.php                # Profile update handler
│   ├── change_password.php       # Password change form
│   ├── update_password.php       # Password update handler + confirmation
│   ├── regusers.php              # Registered members table
│   ├── view_issued_book.php      # All issued books table
│   ├── registered_user.php       # User count helper
│   └── registered_book.php       # Book count helper
│
├── dashboardmainpage/
│   ├── sidebar.php               # Reusable member navigation include
│   ├── user-dashboard.php        # Member dashboard
│   ├── view_profile.php          # Member profile view
│   ├── edit_profile.php          # Member profile editor
│   ├── update.php                # Profile update handler
│   ├── change_password.php       # Password change form
│   ├── update_password.php       # Password update handler + confirmation
│   └── view_issued_book.php      # Member's issued books table
│
├── Add_books_lms/
│   ├── add_book.php              # Add new book form
│   ├── manage_book.php           # Book list with edit/delete actions
│   ├── edit_book.php             # Edit book form
│   ├── delete_book.php           # Delete handler + toast redirect
│   ├── regbooks.php              # Full book catalog (read-only)
│   └── registered_book.php       # Book count helper
│
├── Manage_Book_Categories/
│   ├── add_cat.php               # Add new category form
│   ├── manage_cat.php            # Category list with edit/delete
│   ├── edit_cat.php              # Edit category form
│   ├── delete_cat.php            # Delete handler + toast redirect
│   └── Regcat.php                # Categories list (read-only)
│
└── Issue_book_Module/
    └── issue_book.php            # Issue book to member form
```

---

## ⚙️ Installation & Setup

### 1. Prerequisites
- PHP 7.0+ (tested on PHP 8.2.12)
- MySQL 5.6+ or MariaDB
- Apache / Nginx (or XAMPP / WAMP / Laragon)
- Modern browser (Chrome, Firefox, Edge, Safari)

### 2. Deploy
1. Place the `lms/` folder inside your web server's document root (e.g. `htdocs/`, `www/`, or `public_html/`)
2. Start Apache and MySQL
3. Open **`http://localhost/lms/create_admin.php`** in your browser
4. The script will:
   - Create the `lms` database (if missing)
   - Create all six required tables
   - Insert a default administrator account
5. **Delete `create_admin.php`** from the server for security

### 3. Default Database Connection
```
Host:     localhost
Username: root
Password: (empty)
Database: lms
```

To change credentials, update each `mysqli_connect("localhost","root","")` call in the PHP files.

### 4. Default Admin Login
```
Email:    admin@aurora.library
Password: admin123
```

After first login, change the password from **Change Password** in the sidebar.

---

## 🔗 Quick URL Reference

### Authentication
- Member sign-in: `http://localhost/lms/login_module/index.php`
- Admin sign-in: `http://localhost/lms/login_module/admin_login.php`
- Signup: `http://localhost/lms/login_module/signup.php`

### User Portal
- Dashboard: `http://localhost/lms/dashboardmainpage/user-dashboard.php`

### Admin Console
- Dashboard: `http://localhost/lms/Admin_Dashboard_Module/admin_dashboard.php`
- Members: `http://localhost/lms/Admin_Dashboard_Module/regusers.php`
- Book Catalog: `http://localhost/lms/Add_books_lms/regbooks.php`
- Issue Book: `http://localhost/lms/Issue_book_Module/issue_book.php`

> **Tip:** Once logged in, always use the sidebar links rather than typing URLs.

---

## 🎨 Design System — Aurora

The visual language is defined by `aurora.css`. Key design tokens:

| Token | Value | Use |
|-------|-------|-----|
| `--ink-900` | `#0a0e1a` | Primary dark, sidebar background |
| `--gold-600` | `#c9a227` | Brand accent, active states |
| `--paper` | `#fbfaf7` | App background |
| `--shadow-lg` | `0 20px 48px rgba(10,14,26,0.12)` | Card elevation |
| `--r-xl` | `20px` | Default card radius |

**Typography pairing:**
- **Playfair Display** (serif, italic accents) — page titles, hero text, "∅" empty states
- **Inter** (sans-serif) — body, UI, buttons, labels
- **JetBrains Mono** — ISBNs, IDs, technical data

**Animation primitives:**
- `.fade-in`, `.fade-up` — single-element reveals
- `.stagger > *:nth-child(n)` — cascading grid reveals
- `@keyframes drift` — slow background pattern animation on auth screens
- `@keyframes scroll` — infinite marquee
- `@keyframes slideIn` — toast entry
- `@keyframes spin` — loading button spinner (auto-injected by `aurora.js`)

---

## 🧩 Adding a New Admin Later

Run this SQL in phpMyAdmin (or via the MySQL CLI) inside the `lms` database:

```sql
INSERT INTO admins (name, email, password, mobile) VALUES
  ('Your Name', 'you@example.com', 'your_password', 9999999999);
```

Then sign in at `login_module/admin_login.php`.

---

## 🛣️ Roadmap / Known Gaps

The following features are referenced in the UI but not yet implemented:

- **Forgot Password** flow (links exist on login pages)
- **Author management** CRUD (only `add_author.php` is wired into the issue-book dropdown — dedicated add/manage pages are pending)
- **Book return** workflow (no way to mark an issued book as returned)
- **Due date tracking & overdue notifications** (issue_date is stored but no return-by-date logic)
- **Full-text book search** for members (currently members can only see books already issued to them)
- **Email notifications** (registration confirmation, due-date reminders)
- **Password hashing** (currently uses plain text — see Security Notes)

---

## 🔒 Security Notes

This is an **academic / learning project**. The following should be addressed before production use:

- ⚠️ **Passwords are stored in plain text** — switch to `password_hash()` and `password_verify()`
- ⚠️ **SQL queries use string interpolation** — switch to prepared statements (`mysqli_prepare`) to prevent SQL injection
- ⚠️ **No CSRF protection** on form submissions
- ⚠️ **No session regeneration** on login
- ⚠️ **No rate limiting** on login attempts

---

## 📜 License

This project is intended for educational purposes. Feel free to fork, learn from, and adapt it for your own coursework or portfolio.

---

**Aurora Library** — *Where knowledge meets elegance.*
#   a u r o r a - l i b r a r y  
 