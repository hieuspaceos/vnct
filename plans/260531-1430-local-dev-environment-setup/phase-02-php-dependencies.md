---
title: "Phase 02 - Install PHP Dependencies"
description: "Run composer install to install Laravel framework and all packages"
status: pending
priority: P1
effort: 15m
---

## Context

**Project:** VNCT Laravel Application
**Work Context:** `/Users/hieuspace/Desktop/CODE/vnct-vietnamconnect/vnct`
**Reports:** `/Users/hieuspace/Desktop/CODE/vnct-vietnamconnect/vnct/plans/reports/`

## Overview

Install Laravel 8.54 framework and all required PHP packages via Composer. Vendor directory exists but may be incomplete.

## Requirements

| Package | Version | Purpose |
|---------|---------|---------|
| laravel/framework | ^8.54 | Core framework |
| laravel/jetstream | ^2.4 | Auth scaffolding |
| livewire/livewire | ^2.5 | Interactive components |
| ckfinder/ckfinder-laravel-package | v3.5.2.1 | File management |
| bumbummen99/shoppingcart | ^4.0 | E-commerce cart |

## Dependency Analysis

Verified from `composer.json:7-21`:
- 10 runtime dependencies
- 7 dev dependencies
- PHP autoload includes `app/Helpers/Helper.php`

## Implementation Steps

### Step 1: Navigate to Project Directory

```bash
cd /Users/hieuspace/Desktop/CODE/vnct-vietnamconnect/vnct
```

### Step 2: Check Vendor Directory

```bash
ls -la vendor/  # If populated, skip install
```

**NOTE:** vendor/ directory exists (from original source code). If `php artisan --version` works, skip this phase.

If vendor directory is corrupted or `php artisan` fails:

### Step 3: Run Composer Install

```bash
composer install
```

If vendor directory is corrupted:
```bash
rm -rf vendor composer.lock
composer install
```

### Step 4: Verify Installation

```bash
php artisan --version  # Should return Laravel 8.54.x
```

## Todo List

- [ ] Navigate to project directory
- [ ] Check if vendor directory is populated
- [ ] Run `composer install`
- [ ] Verify Laravel artisan is accessible

## Success Criteria

1. `php artisan --version` returns `Laravel Framework 8.54.x`
2. `vendor/autoload.php` exists
3. No fatal errors during install

## Failure Modes

| Failure | Diagnosis | Fix |
|---------|-----------|-----|
| Memory limit errors | PHP memory_limit too low | `php -d memory_limit=512M composer install` |
| Missing extension | PHP missing required extension | Install extension via Homebrew |
| Authentication errors | GitHub rate limits | Use `--no-plugins` or add auth token |

## Next Steps

Phase 03: Install Node.js dependencies
