<div align="center">

<br />

```
 █████╗ ███╗   ██╗██╗ ██████╗ ██████╗ ███╗   ███╗
██╔══██╗████╗  ██║██║██╔════╝██╔═══██╗████╗ ████║
███████║██╔██╗ ██║██║██║     ██║   ██║██╔████╔██║
██╔══██║██║╚██╗██║██║██║     ██║   ██║██║╚██╔╝██║
██║  ██║██║ ╚████║██║╚██████╗╚██████╔╝██║ ╚═╝ ██║
╚═╝  ╚═╝╚═╝  ╚═══╝╚═╝ ╚═════╝ ╚═════╝ ╚═╝     ╚═╝
```

**The ecommerce platform that actually runs where your store lives.**

No plugins. No SSH. No $40/month middleware. No excuses.

<br />

[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![PHP: 7.4+](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://php.net)
[![Hosting: Shared OK](https://img.shields.io/badge/Hosting-Shared%20OK-brightgreen.svg)](#)
[![Status: Building in Public](https://img.shields.io/badge/Status-Building%20in%20Public-orange.svg)](#)
[![Contributors Welcome](https://img.shields.io/badge/Contributors-Welcome-purple.svg)](CONTRIBUTING.md)
[![PRs Welcome](https://img.shields.io/badge/PRs-Welcome-brightgreen.svg)](CONTRIBUTING.md)

<br />

[Why ANICOM](#-why-anicom) · [Features](#-what-ships-by-default) · [Quick Start](#-quick-start) · [Architecture](#-architecture) · [Contribute](#-contribute) · [Roadmap](#-roadmap)

<br />

</div>

---

## 🔥 Why ANICOM

Most ecommerce store owners are not developers. They are bakers, boutique owners, artists, and entrepreneurs. Yet every platform available today either:

- **Costs too much** (Shopify at $39–$399/month)
- **Requires a developer** (WooCommerce plugin hell)
- **Needs a VPS and SSH access** (most self-hosted options)
- **Breaks on updates** (constantly)

ANICOM exists for the store owner who has a **$5/month shared hosting plan** and deserves the same quality experience as someone paying $299/month for Shopify Plus.

> *"If your hosting supports PHP and MySQL — ANICOM runs on it. Full stop."*

---

## ⚡ What Makes ANICOM Different

| Feature | Shopify | WooCommerce | ANICOM |
|--------|---------|-------------|--------|
| Runs on shared hosting | ❌ | ✅ | ✅ |
| No plugin installation needed | ✅ | ❌ | ✅ |
| Server-side tracking built-in | ❌ add-on | ❌ plugin | ✅ native |
| Works without SSH | ✅ | ❌ | ✅ |
| File-based DB emergency fallback | ❌ | ❌ | ✅ |
| Switch DB engine from Admin UI | ❌ | ❌ | ✅ |
| Auto structured data / JSON-LD SEO | partial | plugin | ✅ native |
| Built-in upgrade system | ✅ | ❌ | ✅ |
| Open source | ❌ | ✅ | ✅ |
| Monthly fee | $39–$399 | hosting only | **free** |

---

## 📦 What Ships by Default

Everything below is **included**. Nothing is a plugin. Nothing requires a marketplace purchase.

### 🛍️ Store Core
- Simple, variable, digital, and physical product types
- Categories, tags, collections, and product variants
- Per-variant inventory tracking
- CSV product import and export
- Bulk actions across products and orders

### 🧾 Orders & Customers
- Full order lifecycle: `pending → processing → shipped → delivered → refunded`
- Customer accounts + guest checkout (both work without JavaScript)
- Printable packing slips and invoices
- Customer segmentation with basic tagging

### 💳 Payments
- Stripe, PayPal, manual bank transfer, cash on delivery
- Configured entirely from the Admin UI — no file editing
- Async webhook handler for reliable payment confirmation

### 🚚 Shipping
- Flat rate, free shipping, weight-based, and zone-based rules
- Multi-zone support (country and region level)
- Shipping options update live at checkout

### 🔍 SEO — Automatic & Proper
- Auto meta title and description for every page
- JSON-LD structured data: `Product`, `BreadcrumbList`, `Organization`, `WebSite`, `SearchAction`
- Open Graph and Twitter Card tags on every page
- Auto-generated and auto-updated XML sitemap
- Canonical URLs enforced everywhere
- `robots.txt` manageable from Admin
- Custom slugs for all entities

### 📡 Server-Side Tracking (Replaces Stape.io)
ANICOM includes a **native server-side tracking engine** — no paid middleware required.

- **Meta/Facebook**: Browser Pixel + Conversions API (CAPI) with deduplication
- **Google Ads**: Browser tag + Enhanced Conversions via API
- **TikTok, Snapchat, Pinterest**: Browser + server Events API
- **Event deduplication**: shared `event_id` between browser and server — ad platforms count each event once
- **Data hashing**: SHA256 on all PII before it leaves your server
- **Consent-aware**: no pixel fires before user consent
- **Retry queue**: failed API calls retry via cron — no lost conversions

> This alone saves ANICOM store owners $50–$200/month in Stape.io or similar fees.

### 📧 Email
- Transactional templates for all order events
- All templates editable from Admin
- PHP `mail()` or SMTP — your choice, configured in Admin
- Email queue with cron-based retry

### 🎨 Themes & Frontend
- PHP-rendered theme system — no build step, no npm
- Mobile-first, responsive by default
- Cart and checkout work with JavaScript disabled
- Official ANICOM themes via a special private installation pattern *(coming later)*

### 📊 Analytics
- Built-in visit counter, sales reports, product performance — no third party needed
- Optional Google Analytics tag injection from Admin

### 🏷️ Discounts & Promotions
- Coupon codes: fixed, percentage, free shipping
- Automatic cart discount rules
- Flash sale scheduling with start and end datetime

---

## 🗄️ Three-Tier Database System

ANICOM is the only ecommerce platform that lets you **switch your database engine from the Admin UI** — with zero data loss.

```
┌─────────────────────────────────────────────────────┐
│                  ANICOM DATA LAYER                  │
│                                                     │
│  Tier 1: File-Based JSON   ← Default / Emergency   │
│  Tier 2: MySQL / MariaDB   ← Recommended           │
│  Tier 3: PostgreSQL/MongoDB ← Advanced / VPS       │
│                                                     │
│  Switch anytime: Admin → Settings → Database        │
│  Compatibility check runs before every switch       │
│  Data exported and imported automatically           │
└─────────────────────────────────────────────────────┘
```

The **file-based tier** is never removed. If your database goes down, ANICOM keeps running.

---

## 🚀 Quick Start

### Requirements
- PHP 7.4 or higher
- Apache with `mod_rewrite` enabled
- MySQL 5.7+ (optional — file-based mode works without it)
- A shared hosting account **or** XAMPP locally

### Local Development (XAMPP)
```bash
# 1. Clone the repository
git clone https://github.com/your-org/anicom.git

# 2. Place in your XAMPP htdocs folder
# Windows: C:/xampp/htdocs/anicom
# macOS:   /Applications/XAMPP/htdocs/anicom

# 3. Start Apache and MySQL in XAMPP Control Panel

# 4. Visit http://localhost/anicom/
# The setup wizard will guide you through the rest.
```

### Shared Hosting
```
1. Download the latest ANICOM release zip
2. Upload and extract to your public_html folder via FTP or File Manager
3. Visit yourdomain.com in your browser
4. The setup wizard handles everything from there
```

No Composer. No npm. No terminal. No SSH. Just upload and go.

---

## 🏗️ Architecture

```
/anicom/
├── index.php                  ← Storefront entry point
├── .htaccess                  ← URL rewriting + security
├── admin/                     ← Admin CMS backend
│   ├── controllers/
│   ├── views/
│   └── assets/
├── core/                      ← PHP engine
│   ├── Router.php
│   ├── Database/
│   │   ├── DriverInterface.php
│   │   ├── FileDriver.php     ← Flat-file JSON
│   │   ├── MysqlDriver.php
│   │   └── PgsqlDriver.php
│   ├── Tracking/              ← Server-side tracking engine
│   │   ├── MetaCAPI.php
│   │   ├── GoogleAds.php
│   │   ├── Deduplicator.php
│   │   └── EventIdGenerator.php
│   ├── SEO.php
│   └── Mailer.php
├── themes/
│   └── default/               ← PHP + HTML + CSS themes
├── uploads/                   ← Store media (never touched by updates)
├── anicom-data/               ← Flat-file database storage
├── config/                    ← Environment config
├── migrations/                ← Auto-running DB migrations
└── cron/                      ← Background jobs
```

**Design principles:**
- Every DB query goes through `DriverInterface` — swap engines without touching business logic
- Views receive only pre-processed data — zero logic in templates
- All output is `htmlspecialchars()` escaped — always
- CSRF tokens on every POST form — always
- No external dependency required for core to function

---

## 🛡️ Security Standards

- PDO prepared statements on all queries — no string concatenation SQL
- SHA256 hashing on all PII before external API calls
- CSRF protection on every form
- Rate limiting on login (5 attempts → 15-minute lockout, file-based — no Redis needed)
- `/config/`, `/core/`, `/anicom-data/` blocked from public access via `.htaccess`
- File uploads: whitelist-only types, renamed on upload, execution disabled
- Admin path is configurable — move it away from `/admin/`

---

## 🔄 Upgrade System

ANICOM updates should never be scary.

- Update checker pings GitHub Releases for new versions
- Admin is notified with a changelog summary
- One-click upgrade: auto-backup → download → extract → migrate → verify
- One-click rollback if anything goes wrong
- `/uploads/`, `/themes/`, `/anicom-data/` are **always excluded** from upgrades — your data is never touched

---

## 🗺️ Roadmap

### Phase 1 — Foundation *(active)*
- [x] Project architecture and master specification
- [ ] Core PHP router with `.htaccess` clean URLs
- [ ] File-based JSON database driver
- [ ] MySQL database driver with migration runner
- [ ] Admin authentication (login, session, CSRF, rate limiting)
- [ ] 10-step onboarding wizard
- [ ] Admin dashboard shell
- [ ] Product CRUD with image upload and GD resize
- [ ] Basic storefront (home, product list, product detail)
- [ ] Session-based cart (PHP fallback, JS enhanced)
- [ ] Checkout and order creation
- [ ] SEO engine (meta, JSON-LD, sitemap, OG)
- [ ] Email queue and transactional templates

### Phase 2 — Tracking & Growth
- [ ] Meta Conversions API with event deduplication
- [ ] Google Ads Enhanced Conversions
- [ ] TikTok and Snapchat Events API
- [ ] Consent mode and cookie banner
- [ ] Coupon and discount engine
- [ ] Customer accounts and order history
- [ ] CSV import/export

### Phase 3 — Ecosystem
- [ ] PostgreSQL driver
- [ ] MongoDB driver
- [ ] Theme system finalization
- [ ] Official theme program *(private installation pattern)*
- [ ] Multi-language support
- [ ] Multi-currency support
- [ ] REST API for headless use

---

## 🤝 Contribute

ANICOM is being **built in public**. Every decision, every debate, every design choice happens openly on GitHub. You are welcome at any level.

### Who We Need Right Now

| Role | What You'd Work On |
|------|-------------------|
| **PHP Developers** | Core engine, database drivers, Admin controllers |
| **Frontend Developers** | Admin UI, default theme, checkout flow |
| **SEO Specialists** | Validate schema output, structured data, sitemap logic |
| **Security Researchers** | Audit auth, CSRF, input handling, file uploads |
| **Technical Writers** | Documentation, code comments, contributor guides |
| **Store Owners / Testers** | Real-world testing on actual shared hosting accounts |

### Ground Rules for Contributors

1. **Every feature must run on XAMPP and standard shared hosting** — no exceptions
2. **File-based DB mode stays functional at all times** — never break Tier 1
3. **No external library without explicit approval** + shared hosting compatibility check
4. **JS must enhance, never replace** — PHP fallback first, always
5. **SEO output validated against Google Rich Results Test** before PR merge
6. **No SSH dependency** — if setup needs a terminal, the PR is rejected

### How to Contribute

```bash
# 1. Fork the repository
# 2. Create your feature branch
git checkout -b feature/your-feature-name

# 3. Write your code following the standards in CONTRIBUTING.md
# 4. Test on XAMPP locally
# 5. Submit a pull request with a clear description
```

Read [CONTRIBUTING.md](CONTRIBUTING.md) for the full coding standards, branch naming, and PR process.

**First time contributing to open source?** Look for issues tagged [`good first issue`](../../issues?q=label%3A%22good+first+issue%22) — they are specifically scoped for new contributors.

---

## 💬 Community

- **GitHub Discussions** — architecture decisions, feature requests, questions
- **Issues** — bug reports and tracked tasks
- **Pull Requests** — where the code gets reviewed and merged

We are a respectful, beginner-friendly community. Every question is a good question.

---

## 📄 License

ANICOM is released under the [MIT License](LICENSE).

You can use it, modify it, sell stores built on it, and contribute back.  
You cannot claim you built ANICOM.

---

<div align="center">

<br />

**ANICOM — Ecommerce for everyone.**

*No plugins. No SSH. No excuses.*

<br />

⭐ **Star this repo if you believe every store owner deserves a fair shot.** ⭐

<br />

Built in public · Powered by PHP · Runs on a $5 host · Forever open source

</div>
