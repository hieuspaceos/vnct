---
title: "VNCT Local Development Environment Setup"
description: "Set up working Laravel dev environment with MySQL database for Vietnam Connect application"
status: pending
priority: P1
effort: 3h
tags: [laravel, local-dev, mysql, environment-setup]
created: 2026-05-31
---

## Overview

Set up a complete local development environment for the VNCT Laravel application (v8.54) on macOS with Homebrew-managed dependencies.

## Current State

- Source code: present
- vendor/: Already exists (from original source code)
- node_modules/: Unknown status
- Database: `database/vnct.sql` (1.3MB, ready to import)
- No `.env` file
- No `.env.example` file (must create manually)
- PHP, MySQL, Composer: NOT installed → MUST install

## Target State

- PHP 8.1+ via Homebrew
- MySQL 8.0 via Homebrew
- Composer for PHP deps
- npm for Node deps
- Laravel app with working admin panel at `/admin`

## Phases

| Phase | Name | Status | Duration |
|-------|------|--------|----------|
| 01 | Install Prerequisites | pending | 30min |
| 02 | Install PHP Dependencies | pending | 15min |
| 03 | Install Node Dependencies | pending | 10min |
| 04 | Configure Environment | pending | 15min |
| 05 | Set Up Database | pending | 30min |
| 06 | Create Storage Link | pending | 5min |
| 07 | Verify Application | pending | 15min |

## Key Dependencies

- **Phase 01** blocks: all subsequent phases
- **Phase 04** blocks: Phase 05, 06, 07
- **Phase 05** blocks: Phase 07

## Success Criteria

1. `php artisan serve` starts without errors
2. MySQL connection works via `.env` credentials
3. Admin login page accessible at `/admin/login`
4. Database migrations run successfully
5. Frontend assets compile without errors

## Risks

| Risk | Likelihood | Impact | Mitigation |
|------|-------------|--------|------------|
| MySQL import fails (large file) | Medium | High | Split SQL file or increase MySQL timeout |
| PHP extension issues | Medium | Medium | Use Homebrew's pre-built PHP with extensions |
| Port 3306 conflict | Low | Low | Use 3307 or stop conflicting service |

## Rollback

- Homebrew packages: `brew uninstall php mysql`
- Database: `DROP DATABASE vnct`
- .env: delete and document required variables
