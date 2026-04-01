<?php
/*
 * public/actions/do-create-event.php — Create Event Action (POST handler)
 * --------------------------------------------------------------------------
 * Processes: POST title, description, event_date, location + optional image upload
 * Uses: EventModel::create(), functions.php::handleUpload() for image
 * Validates: required fields, date format, club session role
 * On success: redirects to club.php?id={clubId}
 * On failure: redirects to create-event.php with errors in flash
 * Pattern: Post/Redirect/Get
 */
