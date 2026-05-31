# VNCT - Vietnam Connect

Web platform for Association for Culture and Tourism of Vietnam in Europe (ACTV Europe), based in Paris.

## Project Overview

- **Type:** Laravel 8.54 PHP Web Application
- **PHP Version:** 7.3+ / 8.0
- **Database:** MySQL/MariaDB
- **Location:** Paris, France

## Technology Stack

| Component | Version | Purpose |
|-----------|---------|---------|
| Laravel | 8.54 | PHP Framework |
| Jetstream | 2.4 | Auth scaffolding + Sanctum |
| Livewire | 2.5 | Interactive components |
| Sanctum | 2.11 | API authentication |
| CKFinder | 3.5.2.1 | File management |
| CKEditor | - | Rich text editing |
| ShoppingCart | 4.0 | E-commerce cart |
| PHPMailer | 6.5 | Email sending |
| Socialite | 5.2 | Social OAuth |
| Tailwind CSS | - | Styling |

## Key Features

- **Multilingual Support:** French (fr), Vietnamese (vi), English (en), Spanish (es)
- **E-commerce:** Product catalog with cart, orders, coupons
- **Business Portal:** Business registration and approval workflow
- **Content Management:** Posts, categories, pages, portfolios, members
- **Contact System:** Contact forms, FAQs, reviews, newsletters
- **Admin Panel:** Full CMS for managing all content

## Directory Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── admin/          # 14 admin controllers
│   │   ├── Api/            # API controllers
│   │   ├── Auth/           # Jetstream auth
│   │   ├── BusinessAuthController.php, CartController.php
│   │   ├── MailerController.php, PagesController.php
│   │   ├── SearchController.php, SocialController.php
│   │   └── UserController.php
│   ├── Lib/                 # Business logic (Order_lib, Product_lib, Coupon_lib, Terms_lib)
│   ├── Livewire/            # Livewire components (OrdersTable)
│   ├── Middleware/          # 15 middleware files
│   └── Requests/           # Form requests
├── Models/                 # 28 Eloquent models
├── Helpers/                 # Helper.php, FrontEnd.php
├── Scopes/                  # where_language global scope
├── Mail/                    # Email classes
└── Providers/              # 9 service providers
config/                     # 21 config files
database/vnct-db.sql        # Database dump (~1.4MB)
resources/views/
├── admin/                   # Admin templates
├── page/                    # Frontend templates
├── blocks/                  # Blade components
├── business/                # Business portal views
├── auth/                    # Jetstream auth views
└── emails/                  # Email templates
```

## Quick Start

```bash
# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Start development server
php artisan serve
```

## Admin Access

- **URL:** `/admin/login`
- **Default credentials:** Configure in `.env`

## API Endpoints

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/api/getcateandproduct` | GET | Get categories and products |
| `/api/getproductdetail` | GET | Product details |
| `/api/facebook-login` | GET | Facebook OAuth |
| `/api/loginBiometric` | POST | Biometric login |

## Multilingual Pattern

Content uses `lang` (1=fr, 2=vi) with `origin_id` for translations. Session-based locale switching via `/language/{lang}` routes.

## Database Schema

Key tables: `users`, `businesses`, `posts`, `terms`, `terms_posts`, `configs`, `orders`, `coupons`, `contacts`, `faqs`, `members`, `portfolio`

## License

MIT