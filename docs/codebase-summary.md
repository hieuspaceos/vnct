# Codebase Summary - VNCT

## Overview

Laravel 8.54 application with 28 Eloquent models, 14 admin controllers, Livewire integration, and custom multilingual system.

## Application Structure

```
/Users/hieuspace/Desktop/CODE/vnct-vietnamconnect/vnct/
├── app/
│   ├── Actions/
│   ├── Console/
│   ├── Exceptions/
│   ├── Helpers/
│   │   ├── FrontEnd.php
│   │   └── Helper.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── admin/          # Admin controllers
│   │   │   ├── Api/            # API controllers
│   │   │   ├── Auth/           # Jetstream auth
│   │   │   ├── BusinessAuthController.php
│   │   │   ├── CartController.php
│   │   │   ├── MailerController.php
│   │   │   ├── PagesController.php
│   │   │   ├── SearchController.php
│   │   │   ├── SocialController.php
│   │   │   └── UserController.php
│   │   ├── Lib/
│   │   ├── Livewire/
│   │   ├── Middleware/         # 15 files
│   │   └── Requests/
│   ├── Mail/
│   ├── Models/                 # 28 models
│   ├── Providers/             # 9 providers
│   ├── Scopes/
│   └── View/
├── config/                     # 21 config files
├── database/
│   └── vnct-db.sql           # 1.4MB SQL dump
├── public/
│   ├── uploads/              # album, avatar, banner, images, members, review
│   ├── ckeditor/
│   ├── datatables/
│   └── template/             # admin/, css/, fonts/, js/, webfonts/
├── resources/
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── blocks/           # Blade components
│       ├── business/
│       ├── emails/
│       ├── page/            # Frontend pages
│       └── vendor/
├── routes/
│   ├── web.php              # Main routes
│   ├── api.php              # API routes
│   ├── console.php
│   └── channels.php
└── storage/
```

## Controllers (21 total)

### Frontend Controllers
| Controller | File | Purpose |
|------------|------|---------|
| PagesController | PagesController.php | Homepage, detail, listing pages |
| CartController | CartController.php | Shopping cart operations |
| MailerController | MailerController.php | Email sending |
| SearchController | SearchController.php | Search functionality |
| BusinessAuthController | BusinessAuthController.php | Business login/register |
| SocialController | SocialController.php | Facebook OAuth |
| UserController | UserController.php | User order history |

### Admin Controllers (14)
| Controller | File | Purpose |
|------------|------|---------|
| PageController | admin/PageController.php | Categories, products, posts, config (31KB) |
| BusinessController | admin/BusinessController.php | Business management |
| Donhang | admin/Donhang.php | Order management |
| FaqController | admin/FaqController.php | FAQ management |
| Coupons | admin/Coupons.php | Coupon management |
| ContactController | admin/ContactController.php | Contact submissions |
| ReviewController | admin/ReviewController.php | Review management |
| PopupController | admin/PopupController.php | Popup management |
| MemberController | admin/MemberController.php | Member directory |
| PortfolioController | admin/PortfolioController.php | Portfolio management |
| UserControllerAdmin | admin/UserControllerAdmin.php | Admin user CRUD |
| UsesnewsController | admin/UsesnewsController.php | Newsletter subscriptions |

### API Controllers
| Controller | File | Purpose |
|------------|------|---------|
| LoginController | Api/LoginController.php | API authentication |
| ProductController | Api/ProductController.php | Product API |

## Models (28 total)

| Model | Table | Key Fields | Relations |
|-------|-------|------------|-----------|
| User | users | name, email, password, Level | - |
| Business | businesses | name, email, status | - |
| Posts | posts | Post_Title, Post_Name, Post_Type, Price, lang, origin_id | Terms (many-many), Color, Size |
| Terms | terms | Name, Slug, Taxonomy, Parent, lang, origin_id | Posts (many-many), self (parent-child) |
| terms_posts | terms_posts | posts_id, terms_id | - |
| Order | orders | CodeOrder, users_id, total, status | order_product |
| order_product | order_product | order_id, posts_id, quantity, price | - |
| Coupon | coupons | code, type, value, limit | coupon_detail |
| Coupon_detail | coupon_details | coupon_id, product_id | - |
| Member | members | name, slug, image, content, lang, origin_id | - |
| Portfolio | portfolios | title, slug, image, content, lang, origin_id | - |
| Config | configs | Value, TieuDe, Type, Page, define, lang, origin_id | - |
| Brand | brands | name | Posts |
| Color | colors | name, code | Posts (via product_color_size) |
| Size | sizes | name | Posts (via product_color_size) |
| product_color_size | product_color_size | posts_id, colors_id, sizes_id, album, soluong, price | - |
| Faq | faqs | question, answer | - |
| Faq_Answer | faq_answers | faq_id, content | - |
| Contact | contacts | name, email, phone, content | - |
| ReviewProduct | review_products | posts_id, name, content, rating, status | - |
| ProductLike | product_likes | posts_id, user_id | - |
| language | languages | Name | - |
| Usernewsletter | usernewsletters | email | - |
| Order_Coupons_Product | order_coupons_products | order_id, coupon_id | - |
| order_coupons | order_coupons | order_id, coupon_id | - |
| PopupListBuy | popup_list_buys | content | - |

## Key Architectural Patterns

### 1. Multilingual System
- **Global Scope:** `where_language` scope on Posts and Terms models
- **Locale Detection:** `App::currentLocale()` used in queries
- **Translation Linking:** `origin_id` field connects translated content
- **Session-based:** Language stored in session via `Session::put('language', $id)`

### 2. Admin Auth Separation
- Admin uses separate `Auth_admin` middleware (not Jetstream)
- Custom login at `/admin/login` route
- Session-based admin authentication
- User (Jetstream) uses `/dashboard` route with Sanctum

### 3. E-commerce Pattern
- `Gloudemans\Shoppingcart\Facades\Cart` for cart
- `product_color_size` pivot table for variant inventory
- Coupon system with `Coupon` and `Coupon_detail` models
- Order flow: cart -> checkout -> Order created -> order_product records

### 4. Taxonomy System (Terms)
- `Taxonomy` field distinguishes category types (tintuc, page, etc.)
- Self-referential parent-child: `Parent` field references parent term
- Many-to-many with Posts via `terms_posts` pivot

### 5. CKFinder Integration
- Routes: `/ckfinder/connector`, `/ckfinder/browser`
- Config: `config/ckfinder.php`
- Used for image/file management in admin

## Routes Summary (web.php - 645 lines)

### Route Groups
| Group | Prefix | Middleware | Purpose |
|-------|--------|------------|---------|
| Business | /business | - | Login, register, logout |
| Carts | /carts | - | Cart operations |
| Admin | /admin | Auth_admin | Full CMS |
| Sanctum | /dashboard | auth:sanctum, verified | User dashboard |

### Key Routes
- `GET /` - Homepage (PagesController@getindex)
- `GET /{slug}.html` - Detail page
- `GET /{slug}/` - Category listing
- `POST /sendmail` - Contact email
- `GET /language/{lang}` - Locale switch
- `GET /auth/facebook` - Facebook OAuth
- `POST /api/review` - Submit review

## Middleware (15 files)

| Middleware | Purpose |
|------------|---------|
| Auth_admin | Check if admin is logged in |
| Is_admin | Check if user is admin role |
| Is_login | Check if user is logged in |
| Others | Laravel defaults (throttle, cors, etc.) |

## Config Files (21)

Key configs:
- `app.php` - App settings, providers
- `database.php` - MySQL connection
- `session.php` - Session config
- `jetstream.php` - Jetstream features
- `fortify.php` - Fortify settings
- `ckfinder.php` - CKFinder settings
- `mail.php` - SMTP settings

## Database Schema

File: `database/vnct-db.sql` (1.4MB)

Key tables with multilingual pattern:
- `users` - Platform users
- `businesses` - Business accounts
- `posts` - Products/content (lang, origin_id)
- `terms` - Categories (lang, origin_id)
- `terms_posts` - Post-category relations
- `configs` - Site config (lang, origin_id)
- `orders` - Purchase orders
- `coupons` - Discount codes
- `members` - Association members (lang, origin_id)
- `portfolio` - Portfolio items (lang, origin_id)

## Helpers

### Helper.php
- `template_tintuc()` - Format news card HTML
- `menu_checkbox()` - Generate nested checkbox menu
- `user_all_childs_ids()` - Get all child term IDs recursively

### FrontEnd.php
- Frontend-specific utility functions

## API Endpoints (routes/api.php)

```php
GET  /getcateandproduct     # Get all categories with products
GET  /getproductdetail      # Product details
GET  /getslide              # Slides
GET  /getallcate            # All categories
GET  /facebook-login        # Facebook OAuth
POST /loginBiometric        # Biometric authentication
```

## Views Structure

```
resources/views/
├── admin/                  # Admin Blade templates
│   ├── layouts/
│   ├── members/
│   ├── portfolio/
│   └── ...
├── auth/                   # Jetstream auth views
├── blocks/                 # Reusable Blade components
│   ├── header.blade.php
│   ├── footer.blade.php
│   └── ...
├── business/               # Business auth views
├── emails/                # Email templates
├── page/                   # Frontend pages
│   ├── home.blade.php
│   ├── trangchitiet.blade.php
│   └── ...
└── vendor/                # Package views
```