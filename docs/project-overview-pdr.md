# Project Overview - VNCT (Vietnam Connect)

## Project Summary

**Project Name:** VNCT - Vietnam Connect
**Type:** Laravel PHP Web Application
**Purpose:** Web platform for Association for Culture and Tourism of Vietnam in Europe (ACTV Europe), Paris
**Target Users:** Vietnamese community in Europe, tourists, business partners

## Business Context

- **Organization:** Association for Culture and Tourism of Vietnam in Europe
- **Location:** Paris, France
- **Focus:** Culture, tourism, community connection

## Technology Stack

| Layer | Technology | Version |
|-------|------------|---------|
| Backend | Laravel | 8.54 |
| Frontend | Blade + Tailwind CSS | - |
| Interactive | Livewire | 2.5 |
| Auth | Jetstream + Sanctum | 2.4 / 2.11 |
| Database | MySQL/MariaDB | - |
| File Manager | CKFinder | 3.5.2.1 |
| E-commerce | ShoppingCart | 4.0 |
| PHP Version | PHP | 7.3+ / 8.0 |

## Core Features

### 1. Content Management
- Posts with categories (news, events, articles)
- Pages with multilingual support
- Portfolio showcase
- Member directory

### 2. E-commerce
- Product catalog with variants (color, size)
- Shopping cart with coupon support
- Order management
- Review and rating system

### 3. Business Portal
- Business registration workflow
- Approval system
- Business profile management

### 4. Multilingual Support
- French (fr), Vietnamese (vi), English (en), Spanish (es)
- Session-based locale switching
- Origin-based translation linking

### 5. Communication
- Contact form
- FAQ system
- Newsletter subscription
- Review submissions

## Data Model

### Key Entities

| Entity | Description | Key Fields |
|--------|-------------|------------|
| User | Platform users | name, email, password, Level |
| Business | Business accounts | name, email, status, approval |
| Posts | Content/products | title, slug, content, price, type |
| Terms | Categories/taxonomies | name, slug, taxonomy, parent |
| Terms_posts | Post-category relations | posts_id, terms_id |
| Order | Purchase orders | code, user_id, total, status |
| Coupon | Discount codes | code, type, value, limit |
| Member | Association members | name, slug, image, lang |
| Portfolio | Portfolio items | title, slug, image, lang |
| Config | Site configuration | key, value, page, type |

### Multilingual Schema

- `lang` field: 1=French, 2=Vietnamese
- `origin_id` field: Links translations to original content
- Global scope `where_language` auto-filters by current locale

## Architecture Overview

```
                    ┌─────────────┐
                    │   Browser   │
                    └──────┬──────┘
                           │
                    ┌──────▼──────┐
                    │  Nginx/     │
                    │  Apache     │
                    └──────┬──────┘
                           │
              ┌────────────▼────────────┐
              │     Laravel App         │
              │  ┌──────────────────┐  │
              │  │  Route Layer     │  │
              │  │  web.php/api.php │  │
              │  └────────┬─────────┘  │
              │           │            │
              │  ┌────────▼─────────┐  │
              │  │  Controllers    │  │
              │  │  Admin/Api/Page  │  │
              │  └────────┬─────────┘  │
              │           │            │
              │  ┌────────▼─────────┐  │
              │  │  Models (Eloquent)│  │
              │  │  28 Models       │  │
              │  └────────┬─────────┘  │
              └────────────┼────────────┘
                           │
              ┌────────────▼────────────┐
              │     MySQL/MariaDB       │
              │   vnct-db.sql (1.4MB)   │
              └─────────────────────────┘
```

## Route Structure

### Frontend Routes
- `/` - Homepage
- `/{slug}.html` - Detail pages
- `/{slug}/` - Category listing
- `/carts/*` - Shopping cart
- `/business/*` - Business auth
- `/language/{lang}` - Locale switching

### Admin Routes
- `/admin/login` - Admin login
- `/admin` - Dashboard (auth required)
- `/admin/danhmuc/*` - Category management
- `/admin/product/*` - Product management
- `/admin/baiviet/*` - Post management
- `/admin/donhang/*` - Order management
- `/admin/members/*` - Member management
- `/admin/portfolio/*` - Portfolio management

### API Routes
- `GET /api/getcateandproduct` - Categories + products
- `GET /api/getproductdetail` - Product details
- `GET /api/getslide` - Slides
- `GET /api/getallcate` - All categories
- `GET /api/facebook-login` - Facebook OAuth
- `POST /api/loginBiometric` - Biometric auth

## Middleware Stack

| Middleware | Purpose |
|------------|---------|
| Auth_admin | Admin authentication check |
| Is_admin | Admin role verification |
| Is_login | User login verification |
| auth:sanctum | Jetstream Sanctum auth |
| verified | Email verification (Jetstream) |

## Configuration Files

| File | Purpose |
|------|---------|
| app.php | App name, env, debug, locale |
| database.php | MySQL connection |
| session.php | Session driver, lifetime |
| jetstream.php | Jetstream features config |
| fortify.php | Fortify auth config |
| ckfinder.php | CKFinder configuration |
| mail.php | Email SMTP settings |

## Security

- Separate admin authentication from Jetstream user auth
- CSRF protection on forms
- Password hashing via bcrypt
- Session-based admin access control
- File upload validation via CKFinder

## Development Guidelines

See [code-standards.md](./code-standards.md) for:
- PHP/Laravel coding standards
- File naming conventions
- Code organization patterns
- Testing requirements

## Project Roadmap

See [project-roadmap.md](./project-roadmap.md) for:
- Development phases
- Milestones
- Future improvements