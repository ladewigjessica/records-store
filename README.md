# Records Store 🎵

A small record shop built in PHP and MySQL. You can browse discs by genre, see details, add to a cart, and check out. There's an admin area for managing the catalogue.

Built in 2022 during a web development course at IEFP. Revisited in 2025 to fix security issues and add features that were missing at the time.

## What it does

- Browse and filter discs by genre
- Disc detail page with larger image
- Shopping cart (session-based)
- Checkout flow — redirects to login if not authenticated
- User registration and login
- Change password
- Admin area: add discs, add genres, edit disc details

## What's missing

Payment integration was never implemented. The checkout button clears the cart and shows a placeholder message.

## Tech

PHP · MySQL · HTML · CSS

## Setup

Requirements: PHP 8+, MySQL, a local server like XAMPP.

1. Clone the repository
2. Import `database.sql` into MySQL — it creates the database and adds sample data
3. Copy the project folder to your server's root (e.g. `htdocs` in XAMPP)
4. Open `http://localhost/records-store`

Default credentials:
- Admin: `admin` / `admin123`
- User: `user` / `user123`

## Security notes

The original 2022 version used raw SQL queries and MD5 password hashing. This version uses prepared statements throughout and `password_hash` / `password_verify` for credentials.
