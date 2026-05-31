---
title: "Phase 01 - Install Prerequisites"
description: "Install PHP 8.1+, MySQL 8.0, and Composer on macOS via Homebrew"
status: pending
priority: P1
effort: 30m
---

## Context

**Project:** VNCT Laravel Application
**Work Context:** `/Users/hieuspace/Desktop/CODE/vnct-vietnamconnect/vnct`
**Reports:** `/Users/hieuspace/Desktop/CODE/vnct-vietnamconnect/vnct/plans/reports/`

## Overview

Install all required system dependencies for the Laravel development environment on macOS using Homebrew.

## Requirements

| Tool | Required Version | Purpose |
|------|------------------|---------|
| PHP | 8.1+ | Laravel 8.54 requires PHP ^7.3\|^8.0 |
| MySQL | 8.0+ | Database server |
| Composer | latest | PHP dependency manager |

## System Analysis (Verified)

- **Node.js:** Already installed (Homebrew)
- **PHP:** Not installed → MUST install
- **MySQL:** Not installed → MUST install
- **Composer:** Not installed → MUST install
- **vendor/:** Already exists (from original source code)
- **node_modules/:** Unknown status (may exist from original source code)

## Implementation Steps

### Step 1: Install PHP 8.1 via Homebrew

```bash
brew install php@8.1
```

Add to PATH (add to `~/.zshrc`):
```bash
echo 'export PATH="/opt/homebrew/opt/php@8.1/bin:$PATH"' >> ~/.zshrc
echo 'export PATH="/opt/homebrew/opt/php@8.1/sbin:$PATH"' >> ~/.zshrc
source ~/.zshrc
```

### Step 2: Install MySQL 8.0 via Homebrew

```bash
brew install mysql@8.0
```

Start MySQL service:
```bash
brew services start mysql@8.0
```

Or manual start:
```bash
/opt/homebrew/opt/mysql@8.0/bin/mysqld_safe --datadir=/opt/homebrew/var/mysql &
```

### Step 3: Install Composer

```bash
brew install composer
```

### Step 4: Verify Installations

```bash
php -v        # Should show PHP 8.1.x
composer -V   # Should show Composer version
mysql --version  # Should show mysql 8.0.x
```

## Todo List

- [ ] Install PHP 8.1 via Homebrew
- [ ] Add PHP to PATH in ~/.zshrc
- [ ] Install MySQL 8.0 via Homebrew
- [ ] Start MySQL service
- [ ] Set MySQL root password
- [ ] Install Composer
- [ ] Verify all tools are accessible

## Success Criteria

1. `php -v` returns PHP 8.1.x
2. `mysql --version` returns MySQL 8.0.x
3. `composer -V` returns Composer version
4. MySQL service is running (`brew services list`)

## Failure Modes

| Failure | Diagnosis | Fix |
|---------|-----------|-----|
| PHP install fails | Check macOS permissions | `sudo xcode-select --install` |
| MySQL won't start | Port 3306 in use | `brew services stop mysql` first |
| Composer install fails | PATH issue | Verify Homebrew in PATH |

## Next Steps

Phase 02: Install PHP dependencies via Composer
