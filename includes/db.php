<?php
/*
 * includes/db.php
 * ---------------
 * Creates and returns a singleton PDO connection.
 * Reads DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS from $_ENV
 * (populated by phpdotenv in config.php — must be included first).
 * Throws a PDOException on connection failure; caught at entry-point level.
 * Required by: every file in includes/models/
 */
