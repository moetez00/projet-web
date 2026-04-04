<?php
/*
 * public/actions/do-register.php — Registration Action (POST handler)
 * ----------------------------------------------------------------------
 * Processes: POST form data from register.php (role + fields vary by role)
 * Uses: UserModel::create(), then StudentModel::create()
 *       or ClubModel::create() depending on role
 * On success: auto-logs-in user (sets session), redirects to index.php
 * On failure: redirects to register.php with validation errors in flash
 * Pattern: Post/Redirect/Get
 */
