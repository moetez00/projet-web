<?php
/*
 * public/profile.php — Student Profile Page
 * -------------------------------------------
 * What the user sees: own avatar, personal info, list of followed clubs,
 *                     and list of liked events.
 * Data needed: StudentModel::getProfile(), FollowModel::getFollowedClubs(),
 *              LikeModel::getLikedEvents() — all for session user.
 * Requires login. Includes: includes/auth.php, header.php, footer.php,
 *                           club-card.php, event-card.php
 */
