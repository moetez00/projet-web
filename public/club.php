<?php
/*
 * public/club.php — Club Profile Page
 * --------------------------------------
 * What the user sees: club cover, description, follower count,
 *                     follow/unfollow button, and list of the club's events.
 * Data needed: ClubModel::findById(?id=), EventModel::getByClub(),
 *              FollowModel::isFollowing() for logged-in student.
 * Includes: includes/auth.php, header.php, footer.php, event-card.php
 */
