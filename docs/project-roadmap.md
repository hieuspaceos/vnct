# Project Roadmap - VNCT (Vietnam Connect)

## Overview

This roadmap tracks the development phases and future improvements for the VNCT Laravel application.

## Current Status

- **Phase:** Active Development
- **Last Updated:** 2026-05-31
- **Version:** 1.1

## Technology Stack

| Component | Current | Target |
|-----------|---------|--------|
| Laravel | 8.54 | 10.x (upgrade path) |
| PHP | 7.3+/8.0 | 8.2+ |
| MySQL | - | 8.0+ |
| Livewire | 2.5 | 3.x |
| Jetstream | 2.4 | 3.x |

---

## Phase 1: Foundation (Completed)

### Objectives
- [x] Laravel 8.54 setup
- [x] Admin authentication system
- [x] Multilingual support (fr, vi, en, es)
- [x] Core content models (Posts, Terms, Members, Portfolio)
- [x] CKFinder integration for file management

### Deliverables
- [x] 28 Eloquent models
- [x] 14 admin controllers
- [x] Frontend controllers (Pages, Cart, Search, Mailer)
- [x] Custom `where_language` global scope
- [x] Language switching via session

---

## Phase 2: E-commerce (Current)

### Objectives
- [x] Product catalog with variants (color, size)
- [x] Shopping cart with coupon support
- [x] Order management system
- [x] Review and rating system

### Deliverables
- [x] CartController with Gloudemans\Shoppingcart
- [x] Product variants via `product_color_size` pivot
- [x] Coupon system (Coupon, Coupon_detail models)
- [x] Order management in admin
- [x] Review submission and display

### In Progress
- [ ] Order confirmation emails
- [ ] Order status notifications
- [ ] Inventory management

---

## Phase 3: Business Portal

### Objectives
- [x] Business registration
- [x] Business approval workflow
- [x] Business profile management

### Deliverables
- [x] Business model and controller
- [x] Registration/login at `/business`
- [x] Admin approval interface
- [ ] Business dashboard
- [ ] Business listing page

### TODO
- [ ] Email notification on approval
- [ ] Business featured listings
- [ ] Business analytics

---

## Phase 4: Content Enhancement

### Objectives
- [ ] FAQ system expansion
- [ ] Newsletter integration
- [ ] Popup management system
- [ ] Contact form enhancement

### Deliverables
- [x] FAQ model and admin interface
- [x] Newsletter subscription (`UsesnewsController`)
- [x] Popup management for marketing
- [ ] Automated email responses
- [ ] Contact form analytics

---

## Phase 5: User Experience

### Objectives
- [ ] Livewire component optimization
- [ ] AJAX-based search
- [ ] Infinite scroll for listings
- [ ] Mobile responsiveness improvements

### Deliverables
- [ ] Livewire datatables for admin
- [ ] Real-time search autocomplete
- [ ] Optimized image loading
- [ ] Progressive web app (PWA) support

---

## Phase 6: API & Integrations

### Objectives
- [ ] REST API expansion
- [ ] Mobile app backend
- [ ] Third-party integrations

### Deliverables
- [ ] JWT authentication option
- [ ] API rate limiting
- [ ] Webhook support for orders
- [ ] Stripe/Payment integration

---

## Phase 7: Performance & Security

### Objectives
- [ ] Code optimization
- [ ] Security hardening
- [ ] Caching implementation

### Deliverables
- [ ] Redis caching for sessions
- [ ] Query optimization (indexes)
- [ ] Image optimization pipeline
- [ ] Security audit (OWASP)
- [ ] Two-factor authentication

---

## Phase 8: Deployment & DevOps

### Objectives
- [ ] CI/CD pipeline
- [ ] Docker containerization
- [ ] Production deployment

### Deliverables
- [ ] GitHub Actions workflow
- [ ] Dockerfile
- [ ] Laravel Forge/Envoyer config
- [ ] Database backup strategy
- [ ] Monitoring setup

---

## Milestones

| Milestone | Target | Status |
|-----------|--------|--------|
| Phase 1: Foundation | Q1 2024 | Completed |
| Phase 2: E-commerce | Q2 2024 | Completed |
| Phase 3: Business Portal | Q3 2024 | Completed |
| Phase 4: Content Enhancement | Q4 2024 | In Progress |
| Phase 5: User Experience | Q1 2025 | Planned |
| Phase 6: API & Integrations | Q2 2025 | Planned |
| Phase 7: Performance & Security | Q3 2025 | Planned |
| Phase 8: Deployment & DevOps | Q4 2025 | Planned |

**Note:** As of 2026-05-31, development timeline has slipped significantly from original plan.

---

## Technical Debt

### High Priority
- [ ] Upgrade Laravel 8.54 to 10.x
- [ ] PHP 8.2 compatibility check
- [ ] Livewire 2.5 to 3.x migration
- [ ] Evaluate `bumbummen99/shoppingcart` replacement (package may be abandoned)

### Medium Priority
- [ ] Refactor large controllers (PageController.php 31KB)
- [ ] Add unit tests for core functionality
- [ ] Document Lib class responsibilities

### Low Priority
- [ ] Code comment cleanup
- [ ] Consistent naming conventions
- [ ] Remove unused routes

---

## Dependencies

### Composer Packages
```json
{
  "laravel/framework": "^8.54",
  "laravel/jetstream": "^2.4",
  "laravel/sanctum": "^2.11",
  "livewire/livewire": "^2.5",
  "ckfinder/ckfinder-laravel-package": "v3.5.2.1",
  "bumbummen99/shoppingcart": "^4.0",
  "mediconesystems/livewire-datatables": "^0.6.8",
  "phpmailer/phpmailer": "^6.5",
  "laravel/socialite": "^5.2"
}
```

---

## Documentation

| Document | Status |
|----------|--------|
| README.md | Updated |
| project-overview-pdr.md | Created |
| codebase-summary.md | Created |
| code-standards.md | Created |
| system-architecture.md | Created |
| project-roadmap.md | This file |

---

## Changelog

### v1.1 (2026-05-31)
- Updated milestones: Phase 2-3 marked completed, Phase 4 in progress
- Added shoppingcart package warning (potential abandonment)
- Added Socialite to dependencies
- Updated Lib layer documentation
- Added Livewire component layer to architecture

### v1.0 (2026-05-31)
- Initial documentation created
- Project structure documented
- Roadmap established