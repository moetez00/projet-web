<?php
/*
 * includes/models/StudentModel.php
 * ---------------------------------
 * OOP model for the `student` table.
 * Extends or delegates to UserModel for auth fields.
 * Connects to: database/schema.sql → student JOIN user
 *
 * Methods:
 *   create($userId, $lastName, $firstName, $major, $year)
 *   findByUserId($userId)
 *   getProfile($studentId)
 *   updateProfile($studentId, $data)
 */
