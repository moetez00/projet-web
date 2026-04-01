<?php
/*
 * includes/models/LikeModel.php
 * ------------------------------
 * OOP model for the `like` join table (student likes event).
 * Connects to: database/schema.sql → like
 *
 * Methods:
 *   like($studentId, $eventId)
 *   unlike($studentId, $eventId)
 *   hasLiked($studentId, $eventId)
 *   getLikedEvents($studentId)
 */
