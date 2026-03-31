<?php
/*
 * includes/models/FollowModel.php
 * ---------------------------------
 * OOP model for the `follow` join table (student follows club).
 * Connects to: database/schema.sql → follow
 *
 * Methods:
 *   follow($studentId, $clubId)
 *   unfollow($studentId, $clubId)
 *   isFollowing($studentId, $clubId)
 *   getFollowedClubs($studentId)
 */
