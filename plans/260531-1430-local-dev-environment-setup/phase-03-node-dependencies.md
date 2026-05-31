---
title: "Phase 03 - Install Node Dependencies"
description: "Run npm install to install frontend assets and build tools"
status: pending
priority: P1
effort: 10m
---

## Context

**Project:** VNCT Laravel Application
**Work Context:** `/Users/hieuspace/Desktop/CODE/vnct-vietnamconnect/vnct`
**Reports:** `/Users/hieuspace/Desktop/CODE/vnct-vietnamconnect/vnct/plans/reports/`

## Overview

Install Node.js dependencies for frontend assets, Tailwind CSS, and Laravel Mix build tools.

## Requirements

| Package | Purpose |
|---------|---------|
| tailwindcss | CSS framework (configured in `tailwind.config.js`) |
| laravel-mix | Asset build tool |
| Various dev dependencies | Compilation and bundling |

Verified from `package.json`:
- Tailwind CSS configured
- Laravel Mix for bundling
- webpack.mix.js present at project root

## Implementation Steps

### Step 1: Navigate to Project Directory

```bash
cd /Users/hieuspace/Desktop/CODE/vnct-vietnamconnect/vnct
```

### Step 2: Run npm Install

```bash
npm install
```

### Step 3: Build Assets (Optional for Dev)

```bash
npm run dev
```

For production build:
```bash
npm run prod
```

## Todo List

- [ ] Navigate to project directory
- [ ] Run `npm install`
- [ ] Verify node_modules created
- [ ] (Optional) Build frontend assets

## Success Criteria

1. `node_modules/` directory exists
2. `npm run dev` completes without errors
3. Tailwind CSS classes are processed

## Failure Modes

| Failure | Diagnosis | Fix |
|---------|-----------|-----|
| node-gyp errors | Missing Xcode CLI tools | `sudo xcode-select --install` |
| Peer dependency warnings | Non-critical | Proceed with `--legacy-peer-deps` |
| Memory issues | Large node_modules | Increase Node memory: `NODE_OPTIONS=--max-old-space-size=4096` |

## Next Steps

Phase 04: Configure environment file (.env)
