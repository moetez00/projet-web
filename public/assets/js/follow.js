/*
 * public/assets/js/follow.js — Follow Button Behaviour
 * ------------------------------------------------------
 * Attaches click handlers to elements with [data-follow-club-id].
 * Sends a fetch() POST to: /actions/do-follow.php with club_id.
 * On JSON response: toggles button label ("Follow" / "Unfollow")
 *                   and updates the displayed follower count in the DOM.
 * Depends on: Bootstrap for button styling classes.
 */
