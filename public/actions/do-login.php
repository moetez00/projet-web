<?php
/*
 * public/actions/do-login.php — Login Action (POST handler)
 * -----------------------------------------------------------
 * Processes: POST email + password from login.php
 * Uses: UserModel::findByEmail(), ::verifyPassword()
 * On success: sets session ($_SESSION['user_id'], $_SESSION['role']),
 *             redirects to index.php
 * On failure: redirects back to login.php with error in session flash
 * Pattern: Post/Redirect/Get
 */
