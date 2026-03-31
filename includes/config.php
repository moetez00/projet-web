<?php
/*
 * includes/config.php
 * -------------------
 * App boot file — the first include in every entry point.
 * 1. Loads vendor/autoload.php (Composer, gives access to phpdotenv).
 * 2. Uses Dotenv\Dotenv to parse .env from the project root into $_ENV.
 * 3. Starts the PHP session (all session logic elsewhere uses auth.php).
 * 4. Defines app-level constants (BASE_URL, UPLOAD_DIR) from $_ENV values.
 * Required by: includes/db.php (must be included first)
 */
