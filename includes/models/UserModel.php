<?php
/*
 * includes/models/UserModel.php
 * ------------------------------
 * OOP model for the `user` table (base account shared by students and clubs).
 * Handles authentication logic: email lookup and password verification.
 * Connects to: database/schema.sql → user
 *
 * Methods:
 *   findByEmail($email)
 *   create($email, $password, $role)
 *   verifyPassword($plain, $hash)
 *   updateAvatar($id, $path)
 */
