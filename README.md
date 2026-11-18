# Campus Connect — Workshop Registration

A **PHP + MySQL** student website where students register for workshops. The form saves each registration into a MySQL table and displays a confirmation screen.

## Files

- `index.php` — student registration form
- `submit.php` — validates and securely saves form submissions
- `success.php` — confirmation screen
- `db.php` — PDO MySQL connection
- `functions.php` — shared helpers, workshop options, and CSRF protection
- `config.example.php` — example credentials (**no real passwords**)
- `database/schema.sql` — SQL for the registration table
- `assets/style.css` — responsive visual design

## Setup with InfinityFree or another PHP + MySQL host

1. Create a PHP-supported hosting account and MySQL database.
2. Open the host's **phpMyAdmin**, select your newly created database, choose **SQL**, paste the contents of `database/schema.sql`, and execute it.
3. Make a copy of `config.example.php` and rename the copy to `config.php`.
4. Edit **only your private `config.php`** to enter the database hostname, database name, database username, and password from your host's database control panel. InfinityFree database names are typically assigned a prefix.
5. Upload `index.php`, `submit.php`, `success.php`, `db.php`, `functions.php`, `config.php`, and the `assets` folder into the website's `htdocs` directory. The `database` folder does not need to be publicly hosted; it is for setup/reference.
6. Open your domain's `index.php` in a browser, enter a sample registration, and click **Register for workshop**. A successful submission should show the confirmation page.
7. To verify that the submission was saved, go to phpMyAdmin, open the **registrations** table, and select **Browse**. The new row should contain the submitted name, email, workshop, attendance mode, notes, and submission time.


## How the form works

1. The student selects one of four workshops and fills out their name, email, attendance mode, and optional learning goal.
2. The form sends a `POST` request to `submit.php` with a session-based CSRF token.
3. PHP checks the token, validates the field lengths, email, workshop choice, and attendance mode.
4. PDO runs a **prepared INSERT statement**, saving data to `registrations` in MySQL.
5. PHP redirects to `success.php` and shows a confirmation without exposing database credentials.
6. Submitted data can be reviewed in phpMyAdmin (there is intentionally no public listing of student email addresses).

## Unique features

- Four workshop themes: web design, cybersecurity, data skills, and career preparation
- Online or in-person attendance selection
- Optional learning goals
- Responsive two-column website design
- Server-side validation, prepared SQL statements, HTML escaping, CSRF token, and clear success/error feedback

## Local testing

Use any installed PHP 8.1+ server with PDO MySQL and the `mbstring` extension, plus a local MySQL database. Import `database/schema.sql`, create a private `config.php`, then run `php -S localhost:8000` in this project directory and open http://localhost:8000.


