<?php
/*
 * public/actions/do-like.php — Like/Unlike Action (POST handler)
 * ----------------------------------------------------------------
 * Processes: POST event_id; toggles like state for session student
 * Uses: LikeModel::hasLiked(), ::like(), ::unlike()
 * Returns: JSON { liked: bool, count: int } for fetch() in like.js
 * Requires login with role='student'
 */
