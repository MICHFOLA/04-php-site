# Folacrown Fashion House

A responsive, multi-page website for a fictional fashion house, built as a learning project with PHP 8. The site presents fashion services, introduces the team, accepts enquiries through a validated contact form, and provides a password-gated local inbox for viewing submissions.

## Features

- Shared PHP configuration, header, footer, and navigation across pages.
- Responsive layouts for home, about, services, service details, and contact.
- Data-driven service cards and team profiles.
- Individual service pages using URL slugs and a friendly 404 response.
- Contact form with server-side validation, sticky values, and session-based CSRF protection.
- Contact submissions saved as JSON Lines with timestamps and file locking.
- Local password form for viewing submissions newest-first in a table.
- Escaped dynamic output to reduce the risk of HTML/script injection.

## Tech stack

- PHP 8 with strict typing
- Apache through XAMPP
- HTML5 and CSS3
- PHP sessions
- JSON Lines (`.jsonl`) for local contact-form storage

## Run with XAMPP

1. Install and start **Apache** from the XAMPP Control Panel.
2. Place the project in this exact folder:

   ```text
   C:\xampp\htdocs\swd\04-php-site
   ```

3. Open the site in your browser:

   [http://localhost/swd/04-php-site/](http://localhost/swd/04-php-site/)

4. To view contact submissions locally, open:

   [http://localhost/swd/04-php-site/messages.php](http://localhost/swd/04-php-site/messages.php)

5. The local inbox password is set in `includes\config.php` as `$messagesPassword`. For this learning project its initial value is `change-this-local-password`; change it before using the page, even on a shared local computer.

Contact submissions are appended to `storage\messages.jsonl`. Apache's `storage\.htaccess` denies direct web access to that folder. Ensure the Apache/PHP process can write to `storage` for the contact form to save messages.

## Project structure

```text
04-php-site\
|-- about.php
|-- contact.php
|-- index.php
|-- messages.php
|-- README.md
|-- service.php
|-- services.php
|-- assets\
|   \-- css\
|       \-- style.css
|-- includes\
|   |-- config.php
|   |-- data.php
|   |-- footer.php
|   |-- functions.php
|   \-- header.php
|-- storage\
|   |-- .htaccess
|   \-- messages.jsonl  (created when the first contact form submission is saved)
```

## What I learned

Fill in these prompts as you work through the project:

- **PHP includes and page structure:** I learned...
- **Associative arrays and foreach loops:** I learned...
- **Functions, strict types, and type hints:** I learned...
- **Escaping output and validating input:** I learned...
- **Sessions, CSRF tokens, and redirects:** I learned...
- **Writing and reading JSON Lines files:** I learned...
- **One thing I would improve next:** I would...

## Local-learning security note

The inbox password is hard-coded in a PHP configuration file and compared directly. This is only a simple local-learning gate, not production authentication. It does not provide password hashing, user accounts, login throttling, access auditing, or broader authorization controls. Do not deploy this inbox or store real sensitive submissions with this setup. A production system should use a proper authentication mechanism, store password hashes in a protected database or secret store, enforce HTTPS, and apply appropriate access controls.
