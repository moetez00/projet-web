<?php
/*
 * includes/models/ClubModel.php
 * ------------------------------
 * OOP model for the `club` table.
 * Connects to: database/schema.sql → club JOIN user
 *
 * Methods:
 *   create($userId, $name, $description, $category)
 *   findById($id)
 *   findByUserId($userId)
 *   getAll()
 *   getFollowerCount($clubId)
 *   updateProfile($clubId, $data)
 */
