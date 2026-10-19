# ShadowCore v2
>[!WARNING]
> This version of the core is NOT finished and is still being written. do not use this in production.

A brand new rewrite of the original v1 ShadowCore, with better security, frontend, and more.
## Features
- features

# Deployment
## Prerequisites
- PHP 8.3+
- Composer
- MySQL/MariaDB
- Node.js / bun
- git

## Installation
### #1. Clone the repository
```bash
git clone https://github.com/ShadowMilo/shadow-core.git
cd shadow-core.git
```
### #2. Install dependencies
```bash
 composer install
```
### #3. Rename .env.example -> .env and configure

### 4. Run migrations
```bash
php artisan migrate
```
### 5. Build the frontend
```bash
bun install
bun run build
```
### 6. Run your webserver

# And that's about it! enjoy your super kewl gdps
