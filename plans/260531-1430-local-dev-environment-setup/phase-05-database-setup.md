---
title: "Phase 05 - Set Up Database"
description: "Create MySQL database and import vnct.sql dump file"
status: pending
priority: P1
effort: 30m
---

## Context

**Project:** VNCT Laravel Application
**Work Context:** `/Users/hieuspace/Desktop/CODE/vnct-vietnamconnect/vnct`
**Reports:** `/Users/hieuspace/Desktop/CODE/vnct-vietnamconnect/vnct/plans/reports/`

## Overview

Create the `vnct` MySQL database and import the 1.3MB SQL dump from `database/vnct.sql`.

## Database Analysis

| Property | Value |
|----------|-------|
| File | `database/vnct.sql` |
| Size | 1.3MB (1,384,770 bytes) |
| Format | MySQL dump with CREATE TABLE and INSERT statements |

## Implementation Steps

### Step 1: Ensure MySQL is Running

```bash
brew services list | grep mysql
```

If not running:
```bash
brew services start mysql@8.0
```

### Step 2: Create Database

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS vnct CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Step 3: Set MySQL Root Password (if needed)

```bash
mysql -u root -e "ALTER USER 'root'@'localhost' IDENTIFIED BY 'root';"
```

Update `.env`:
```env
DB_PASSWORD=root
```

### Step 4: Import SQL Dump

```bash
mysql -u root vnct < database/vnct.sql
```

For larger timeout:
```bash
mysql -u root --max_allowed_packet=512M vnct < database/vnct.sql
```

### Step 5: Verify Import

```bash
mysql -u root vnct -e "SHOW TABLES;" | wc -l
```

Expected: Multiple tables (users, posts, businesses, orders, etc.)

### Step 6: Check Admin User

```bash
mysql -u root vnct -e "SELECT email FROM users LIMIT 1;"
```

## Todo List

- [ ] Verify MySQL service is running
- [ ] Create vnct database with utf8mb4
- [ ] Set root password (if needed)
- [ ] Import database/vnct.sql
- [ ] Verify tables created
- [ ] Check admin user exists

## Success Criteria

1. Database `vnct` exists
2. Tables imported (verify 20+ tables)
3. Admin user exists in `users` table
4. `php artisan migrate` runs successfully (if migrations needed)

## Failure Modes

| Failure | Diagnosis | Fix |
|---------|-----------|-----|
| Access denied | Root password not set | Set with `mysql -u root -e "ALTER USER..."` |
| Import timeout | Large SQL file | Increase MySQL timeout or use `--max_allowed_packet=512M` |
| Import char errors | Encoding mismatch | Add `--default-character-set=utf8mb4` |
| Unknown database | DB not created | `CREATE DATABASE` first |

## Next Steps

Phase 06: Create storage symbolic link
