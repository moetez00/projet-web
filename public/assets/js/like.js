/*
 * public/assets/js/like.js — Like Button Behaviour
 * --------------------------------------------------
 * Attaches click handlers to elements with [data-like-event-id].
 * Sends a fetch() POST to: /actions/do-like.php with evenement_id.
 * On JSON response: toggles button state (filled/outline heart icon)
 *                   and updates the displayed like count in the DOM.
 * Depends on: Bootstrap Icons for heart icon classes.
 */
