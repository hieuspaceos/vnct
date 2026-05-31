# System Architecture - VNCT

## Overview

Laravel 8.54 application with MySQL database, Livewire for interactivity, and custom multilingual system.

## Architecture Layers

```
┌─────────────────────────────────────────────────────────┐
│                    Client Layer                         │
│                  (Browser/Mobile)                       │
└─────────────────────────┬───────────────────────────────┘
                          │ HTTP/HTTPS
┌─────────────────────────▼───────────────────────────────┐
│                    Web Server                             │
│                  (Nginx/Apache)                          │
│                   Port: 80/443                           │
└─────────────────────────┬───────────────────────────────┘
                          │
┌─────────────────────────▼───────────────────────────────┐
│                 Application Layer                         │
│  ┌─────────────────────────────────────────────────────┐│
│  │              Laravel Framework (8.54)               ││
│  │  ┌───────────────────────────────────────────────┐  ││
│  │  │              Route Layer                      │  ││
│  │  │   web.php (main) / api.php (REST)            │  ││
│  │  └───────────────────────────────────────────────┘  ││
│  │                       │                              │
│  │  ┌────────────────────▼────────────────────────────┐│
│  │  │            Controller Layer                       ││
│  │  │  Admin (14) │ Frontend │ API │ Auth              ││
│  │  └──────────────────────────────────────────────────┘│
│  │                       │                              │
│  │  ┌────────────────────▼────────────────────────────┐│
│  │  │           Lib Layer (Business Logic)              ││
│  │  │  Order_lib │ Product_lib │ Coupon_lib │ Terms_lib││
│  │  └──────────────────────────────────────────────────┘│
│  │                       │                              │
│  │  ┌────────────────────▼────────────────────────────┐│
│  │  │       Livewire Component Layer                    ││
│  │  │  OrdersTable (User order history datatable)      ││
│  │  └──────────────────────────────────────────────────┘│
│  │                       │                              │
│  │  ┌────────────────────▼────────────────────────────┐│
│  │  │              Service Layer                       ││
│  │  │   Order_lib │ Helpers │ Middleware                ││
│  │  └──────────────────────────────────────────────────┘│
│  │                       │                              │
│  │  ┌────────────────────▼────────────────────────────┐│
│  │  │              Model Layer (Eloquent)              ││
│  │  │          28 Models + Scopes                       ││
│  │  └──────────────────────────────────────────────────┘│
│  └──────────────────────────────────────────────────────┘│
└─────────────────────────┬───────────────────────────────┘
                          │
              ┌───────────▼────────────┐
              │    Data Layer          │
              │   MySQL/MariaDB        │
              │   vnct.sql (1.3MB)  │
              └────────────────────────┘
```

## Component Architecture

### 1. Request Lifecycle

```
Browser Request
       │
       ▼
Route (web.php/api.php)
       │
       ▼
Middleware (Auth_admin, Is_admin, Is_login)
       │
       ▼
Controller
       │
       ├──► Model (Eloquent ORM)
       │         │
       │         ▼
       │      MySQL Database
       │
       ├──► View (Blade)
       │         │
       │         ▼
       └──► JSON Response (API)
```

### 2. Authentication Flow

```
┌─────────────────────────────────────────────────┐
│              Admin Authentication                │
│                                                 │
│  /admin/login ──► PageController@login          │
│                        │                        │
│                        ▼                        │
│              Session::put('admin', data)        │
│                        │                        │
│                        ▼                        │
│            Auth_admin Middleware checks         │
│                 session on protected routes      │
└─────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────┐
│           User Authentication (Jetstream)        │
│                                                 │
│  /dashboard ──► auth:sanctum, verified          │
│                       │                          │
│                       ▼                          │
│              Sanctum token check                │
│                       │                          │
│                       ▼                          │
│           Jetstream session validation          │
└─────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────┐
│              Business Authentication             │
│                                                 │
│  /business/login ──► BusinessAuthController     │
│       │                                         │
│       ▼                                         │
│  Business::create() or Business::login()       │
│       │                                         │
│       ▼                                         │
│   Admin approval required (status field)       │
└─────────────────────────────────────────────────┘
```

### 3. Multilingual Architecture

```
Session: language ──► App::setLocale($id)
                           │
                           ▼
            GlobalScope: where_language
                           │
                           ▼
              Posts/Terms filtered by lang
                           │
                           ▼
         origin_id links translated content
```

### 4. E-commerce Architecture

```
┌─────────────────────────────────────────────────────────┐
│                    Shopping Cart                         │
│                                                          │
│   Cart::add() ──► Gloudemans\Shoppingcart                │
│        │                                                │
│        ▼                                                │
│   Session: 'shopcart'                                  │
│        │                                                │
│        ▼                                                │
│   CartController@addcart                                │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                    Order Flow                            │
│                                                          │
│   Cart ──► Checkout ──► Order created ──► Confirmation │
│                                                         │
│   Order ──► order_product (items)                       │
│   Order ──► order_coupons (applied coupons)             │
└─────────────────────────────────────────────────────────┘
```

### 5. Content Management Flow

```
┌─────────────────────────────────────────────────────────┐
│                    Admin CMS                             │
│                                                          │
│   /admin/danhmuc ──► Category management (Terms)        │
│   /admin/product ──► Product management (Posts)        │
│   /admin/baiviet ──► Post management (Posts)           │
│   /admin/members ──► Member directory (Members)         │
│   /admin/portfolio ──► Portfolio items                 │
│                                                          │
│   CKFinder Integration:                                 │
│   /ckfinder/connector ──► File upload management       │
│   /ckfinder/browser ──► File browser UI                │
└─────────────────────────────────────────────────────────┘
```

## Directory Structure

```
vnct/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── admin/           # Admin CRUD
│   │   │   │   ├── PageController.php
│   │   │   │   ├── BusinessController.php
│   │   │   │   ├── MemberController.php
│   │   │   │   └── ... (14 total)
│   │   │   ├── Api/             # REST API
│   │   │   ├── Auth/            # Jetstream
│   │   │   └── PagesController.php
│   │   ├── Middleware/
│   │   │   ├── Auth_admin.php
│   │   │   ├── Is_admin.php
│   │   │   └── Is_login.php
│   │   └── Livewire/           # Interactive components
│   ├── Models/                 # 28 Eloquent models
│   ├── Helpers/                # Helper.php, FrontEnd.php
│   └── Scopes/                 # where_language scope
├── config/                      # 21 config files
│   ├── app.php
│   ├── database.php
│   ├── ckfinder.php
│   ├── jetstream.php
│   └── session.php
├── database/
│   └── vnct-db.sql            # Full database dump
├── public/
│   ├── uploads/               # User uploads
│   │   ├── album/
│   │   ├── avatar/
│   │   ├── banner/
│   │   ├── images/
│   │   ├── members/
│   │   └── review/
│   ├── ckeditor/              # CKEditor assets
│   └── template/              # Admin/frontend assets
├── resources/
│   └── views/
│       ├── admin/             # Admin templates
│       ├── page/              # Frontend templates
│       ├── blocks/            # Blade components
│       └── emails/            # Email templates
└── routes/
    ├── web.php                # Main application routes
    ├── api.php                # REST API routes
    └── channels.php           # Broadcasting channels
```

## Database Schema

```
┌─────────────────────────────────────────────────────────┐
│                    Core Tables                           │
├──────────────┬──────────────────────────────────────────┤
│ users        │ id, name, email, password, Level        │
├──────────────┼──────────────────────────────────────────┤
│ businesses   │ id, name, email, status, approval       │
├──────────────┼──────────────────────────────────────────┤
│ posts        │ id, Post_Title, Post_Name, Post_Type,   │
│              │ Price, lang, origin_id, brands_id       │
├──────────────┼──────────────────────────────────────────┤
│ terms        │ id, Name, Slug, Taxonomy, Parent,       │
│              │ lang, origin_id                         │
├──────────────┼──────────────────────────────────────────┤
│ terms_posts  │ terms_id, posts_id (pivot)             │
├──────────────┼──────────────────────────────────────────┤
│ orders       │ id, CodeOrder, users_id, total, status │
├──────────────┼──────────────────────────────────────────┤
│ coupons      │ id, code, type, value, limit            │
├──────────────┼──────────────────────────────────────────┤
│ members      │ id, name, slug, image, content, lang,   │
│              │ origin_id                               │
├──────────────┼──────────────────────────────────────────┤
│ portfolio    │ id, title, slug, image, content, lang,  │
│              │ origin_id                               │
├──────────────┼──────────────────────────────────────────┤
│ configs      │ id, Value, TieuDe, Type, Page, lang,    │
│              │ origin_id                               │
└──────────────┴──────────────────────────────────────────┘
```

## Route Groups

| Group | Prefix | Middleware | Controllers |
|-------|--------|------------|-------------|
| Business | /business | - | BusinessAuthController |
| Carts | /carts | - | CartController |
| Admin | /admin | Auth_admin | 14 admin controllers |
| Auth | / | Jetstream | Auth/* |
| API | /api | - | Api/* |

## Middleware Pipeline

```
Request
   │
   ▼
[throttle:api] ─► [auth:sanctum] ─► [verified] ─► Controller
                     │
                     ▼
              [Auth_admin] for /admin routes
                     │
                     ▼
              [Is_admin] for admin CRUD
```

## Configuration Management

```
.env                 # Environment variables
config/
├── app.php         # App name, env, debug, locale
├── database.php    # MySQL connection
├── session.php     # Session driver, lifetime
├── jetstream.php   # Jetstream features
├── fortify.php     # Fortify settings
├── ckfinder.php    # CKFinder configuration
└── mail.php        # SMTP settings
```

## Key Integration Points

### CKFinder Integration
- Routes: `/ckfinder/connector`, `/ckfinder/browser`
- Config: `config/ckfinder.php`
- Used for: Image/file upload in admin

### ShoppingCart Integration
- Package: `bumbummen99/shoppingcart:^4.0`
- Instance: `Cart::instance('cart')`
- Session: `shopcart`

### Facebook OAuth
- Routes: `/auth/facebook`, `/auth/facebook/callback`
- Controller: `SocialController`

### Email (PHPMailer)
- Config: `config/mail.php`
- Controller: `MailerController`

## Security Architecture

```
┌─────────────────────────────────────────────────────────┐
│                   Security Layers                        │
├─────────────────────────────────────────────────────────┤
│ 1. Route Middleware                                      │
│    - Auth_admin (admin routes)                          │
│    - Is_admin (admin CRUD)                              │
│    - auth:sanctum (user routes)                        │
├─────────────────────────────────────────────────────────┤
│ 2. CSRF Protection                                       │
│    - All POST forms protected                           │
│    - VerifyCsrfToken middleware                        │
├─────────────────────────────────────────────────────────┤
│ 3. Password Security                                     │
│    - bcrypt hashing                                     │
│    - Laravel Hash facade                                │
├─────────────────────────────────────────────────────────┤
│ 4. Session Security                                      │
│    - Session encryption                                  │
│    - Session timeout configuration                      │
└─────────────────────────────────────────────────────────┘
```

## Scaling Considerations

- Database: MySQL/MariaDB with connection pooling
- Sessions: File/Database driver configurable
- Cache: Laravel cache facade ready
- Static Assets: CDN-ready structure in `/public`