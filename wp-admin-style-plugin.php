 <?php
 
 function my_admin_theme_style() {
    /* Creat a wp-plugin-admin.css where you're going to put css for the admin panel */
    wp_enqueue_style('my-admin-theme', plugins_url('wp-plugin-admin.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'my_admin_theme_style');
add_action('login_enqueue_scripts', 'my_admin_theme_style');
