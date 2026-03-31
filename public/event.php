<?php
/*
 * public/event.php — Event Detail Page
 * --------------------------------------
 * What the user sees: full event details (title, event_date, location, image,
 *                     description), like count, and like/unlike button.
 * Data needed: EventModel::findById(?id=), LikeModel::hasLiked(),
 *              EventModel::getLikeCount().
 * Includes: includes/auth.php, header.php, footer.php
 */
