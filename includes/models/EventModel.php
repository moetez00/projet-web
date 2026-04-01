<?php
/*
 * includes/models/EventModel.php
 * --------------------------------
 * OOP model for the `event` table.
 * Connects to: database/schema.sql → event JOIN club
 *
 * Methods:
 *   create($clubId, $title, $description, $eventDate, $location, $image)
 *   findById($id)
 *   getByClub($clubId)
 *   getRecent($limit)
 *   getLikeCount($eventId)
 */
