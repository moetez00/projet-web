<?php
/*
 * public/actions/do-follow.php — Follow/Unfollow Action (POST handler)
 * -----------------------------------------------------------------------
 * Processes: POST club_id; toggles follow state for session student
 * Uses: FollowModel::isFollowing(), ::follow(), ::unfollow()
 * Returns: JSON { following: bool, count: int } for fetch() in follow.js
 * Requires login with role='student'
 */
