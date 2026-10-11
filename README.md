# Assignment 14: Secure Website Form with JavaScript and PHP

## Assignment prompt

Provide an example of secure code for a website that uses JavaScript and PHP to connect to a database.

## Project overview

This example is a small contact form. JavaScript sends the form to a PHP endpoint. PHP validates the request, checks a CSRF token, and stores the data in a MySQL or MariaDB database with a PDO prepared statement.

The browser never connects directly to the database. Database credentials stay on the server in environment variables and are not included in JavaScript or committed to this repository.

## Project files

- **index.php** — accessible contact form and session CSRF token
- **app.js** — same-origin request and safe status display
- **contact.php** — server-side validation and prepared database insert
- **config.php** — secure session settings and PDO connection
- **database.sql** — database and table schema

## Setup

1. Run **database.sql** using a MySQL or MariaDB SQL client. SQL statements are run in a database client, not at the Mac terminal's zsh prompt.
2. Create a dedicated database account for the application. It only needs INSERT permission on the contact_messages table. Do not use the database administrator account in the website.
3. Configure these environment variables on the PHP server:
   - DB_DSN: mysql:host=127.0.0.1;dbname=assignment14_db;charset=utf8mb4
   - DB_USER: the dedicated application account
   - DB_PASSWORD: that account's unique password
4. Serve this folder with PHP and open index.php through the local server. For example, from this folder, run php -S 127.0.0.1:8000 and visit http://127.0.0.1:8000.

For production, use HTTPS and set the DB environment variables in the hosting provider's secret or environment-variable settings. Never put a real database password in this repository.

## Security protections demonstrated

- PDO uses a prepared statement with named parameters, helping prevent SQL injection.
- PHP validates email and message values on the server. Browser-side validation is only a convenience and is not trusted.
- The session token is checked using hash_equals to help prevent cross-site request forgery.
- Session cookies use HttpOnly and SameSite settings. The Secure flag is enabled when the request uses HTTPS.
- JavaScript writes the response with textContent, so it is displayed as text rather than interpreted as HTML.
- PHP returns a generic database error to visitors and logs details on the server.

## Running on GitHub

GitHub stores this project and runs a PHP syntax check through GitHub Actions. GitHub Pages does not execute PHP or connect to a database, so the form needs a PHP-capable server and a configured MySQL-compatible database to run interactively.

## References

- PHP Manual. PDO prepared statements: https://www.php.net/manual/en/pdo.prepared-statements.php
- OWASP Foundation. Cross-Site Request Forgery Prevention Cheat Sheet: https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html
- MDN Web Docs. Node.textContent: https://developer.mozilla.org/en-US/docs/Web/API/Node/textContent
