---
title: "Phase 06 - Create Storage Link"
description: "Create symbolic link for Laravel storage directory"
status: pending
priority: P1
effort: 5m
---

## Context

**Project:** VNCT Laravel Application
**Work Context:** `/Users/hieuspace/Desktop/CODE/vnct-vietnamconnect/vnct`
**Reports:** `/Users/hieuspace/Desktop/CODE/vnct-vietnamconnect/vnct/plans/reports/`

## Overview

Create the symbolic link from `public/storage` to `storage/app/public` for file uploads and media management.

## Requirement

Laravel's storage system requires a symlink for files stored in `storage/app/public` to be accessible via the web.

## Implementation Steps

### Step 1: Create Storage Link

```bash
cd /Users/hieuspace/Desktop/CODE/vnct-vietnamconnect/vnct
php artisan storage:link
```

### Step 2: Verify Link Exists

```bash
ls -la public/storage
```

Expected output: `public/storage -> ../storage/app/public`

### Step 3: Ensure Storage Directories Exist

```bash
mkdir -p storage/app/public
chmod -R 775 storage
```

## Todo List

- [ ] Run `php artisan storage:link`
- [ ] Verify symlink created
- [ ] Ensure storage permissions are correct

## Success Criteria

1. `public/storage` symlink exists
2. `storage/app/public` directory exists
3. No errors from artisan command

## Failure Modes

| Failure | Diagnosis | Fix |
|---------|-----------|-----|
| Link exists | Already created | Skip, no action needed |
| Permission denied | Web server can't write | `sudo chown -R $(whoami):staff storage public` |

## Next Steps

Phase 07: Verify application works
