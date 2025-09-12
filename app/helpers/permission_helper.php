<?php
/**
 * A helper class to centralize all permission/authorization checks.
 */
class Permissions {
    /**
     * Check if the current user can edit a given post.
     * Rule: User must be logged in and be the author of the post.
     *
     * @param object $post The post object, which must contain a user_id property.
     * @return bool
     */
    public static function canEditPost($post) {
        if (!isLoggedIn()) {
            return false;
        }
        if ($post->user_id == $_SESSION['user_id']) {
            return true;
        }
        return false;
    }

    /**
     * Check if the current user can delete a post.
     * Rule: User must be an admin.
     *
     * @param object $post The post object (optional, not used in current rule).
     * @return bool
     */
    public static function canDeletePost($post = null) {
        return isAdmin();
    }

    /**
     * Check if the current user can access the admin dashboard.
     * Rule: User must be an admin.
     *
     * @return bool
     */
    public static function canViewAdminDashboard() {
        return isAdmin();
    }
}
