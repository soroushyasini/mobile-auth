<?php
/*
Plugin Name: Mobile Auth
Description: Mobile login and register with OTP on one page.
Version: 1.1
Author: Milad
*/

if (!defined('ABSPATH')) exit;

add_action('init', function () {
    if (!session_id()) {
        session_start();
    }
}, 1);

register_activation_hook(__FILE__, function () {
    global $wpdb;
    $table = $wpdb->prefix . "users";

    $exists = $wpdb->get_var("SHOW COLUMNS FROM $table LIKE 'mobile'");
    if (!$exists) {
        $wpdb->query("ALTER TABLE $table ADD mobile varchar(20) NULL UNIQUE");
    }

    if (!get_page_by_path('auth')) {
        wp_insert_post([
            'post_title'   => 'Auth',
            'post_name'    => 'auth',
            'post_status'  => 'publish',
            'post_type'    => 'page'
        ]);
    }
    
    if (!get_page_by_path('secret-admin-login')) {
        wp_insert_post([
            'post_title'   => 'Admin Login',
            'post_name'    => 'secret-admin-login',
            'post_status'  => 'publish',
            'post_type'    => 'page'
        ]);
    }
});

add_action('init', function () {
    global $pagenow;

    if ($pagenow === 'wp-login.php') {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return;
        }

        if (!isset($_GET['admin_key']) || $_GET['admin_key'] !== 'hn') {
            if (!is_user_logged_in()) {
                wp_redirect(site_url('/auth'));
                exit;
            }
        }
    }
});

add_action('wp_enqueue_scripts', function () {
    if (is_page('auth')) {
        wp_enqueue_style(
            'mobile-auth-style',
            plugin_dir_url(__FILE__) . 'assets/style.css',
            [],
            '1.0'
        );
    }
});

add_filter('template_include', function ($template) {
    if (is_page('auth')) {
        return plugin_dir_path(__FILE__) . 'templates/auth.php';
    }
    return $template;
});

add_action('template_redirect', function () {
    if (is_page('auth') && isset($_GET['redirect_to'])) {
        $_SESSION['redirect_to'] = esc_url_raw($_GET['redirect_to']);
    }
});

function convert_persian_numbers($string) {
    $persian = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩','۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    $english = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];
    return str_replace($persian, $english, $string);
}

function is_valid_mobile($mobile) {
    $mobile = convert_persian_numbers($mobile);
    return preg_match('/^09\d{9}$/', $mobile);
}

function send_otp_sms($mobile, $code) {

    $url = "https://api.kavenegar.com/v1/75414544654B737133454E4A6D336D485645346C797A43356D676B6648632B5736372B384E524A4E4954343D/verify/lookup.json?" .
        http_build_query([
            'receptor' => $mobile,
            'token' => $code,
            'template' => 'login'
        ]);

    wp_remote_get($url);
}

add_action('init', function () {
    
    global $wpdb;

    if (isset($_POST['send_otp'])) {

        $mobile = sanitize_text_field($_POST['mobile']);
        $mobile = convert_persian_numbers($mobile);

        if (!is_valid_mobile($mobile)) {
            wp_redirect(site_url('/auth?err=format'));
            exit;
        }

        $code = rand(100000, 999999);
        set_transient('otp_' . $mobile, $code, 180);

        send_otp_sms($mobile, $code);

        wp_redirect(site_url('/auth?step=verify&mobile=' . $mobile));
        exit;
    }

    if (isset($_POST['verify_otp'])) {

        $mobile = sanitize_text_field($_POST['mobile']);
        $mobile = convert_persian_numbers($mobile);

        $code = sanitize_text_field($_POST['code']);
        $code = convert_persian_numbers($code);

        $saved = get_transient('otp_' . $mobile);

        if (!$saved || $saved != $code) {
            wp_redirect(site_url('/auth?step=verify&mobile=' . $mobile . '&err=wrong'));
            exit;
        }

        $user_id = $wpdb->get_var(
            $wpdb->prepare("SELECT ID FROM {$wpdb->users} WHERE mobile = %s", $mobile)
        );

        if (!$user_id) {

            $user_id = wp_insert_user([
                'user_login' => 'u' . $mobile,
                'user_pass'  => wp_generate_password(),
                'user_email' => $mobile . '@auth.local'
            ]);

            $wpdb->update(
                $wpdb->users,
                ['mobile' => $mobile],
                ['ID' => $user_id]
            );
            
            set_transient('new_user_' . $user_id, true, 300);
        }

        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
    
        
        if (get_transient('new_user_' . $user_id)) {
            delete_transient('new_user_' . $user_id);
            wp_redirect(site_url('/my-account/profile'));
            exit;
        }
        
        if (!empty($_SESSION['redirect_to'])) {
            $redir = $_SESSION['redirect_to'];
            unset($_SESSION['redirect_to']);
            delete_transient('otp_' . $mobile);
            wp_redirect($redir);
            exit;
        }

        delete_transient('otp_' . $mobile);

        wp_redirect(home_url('/'));
        exit;
    }
});

add_filter('auth_cookie_expiration', function ($seconds, $user_id, $remember) {
    return 30 * DAY_IN_SECONDS;
}, 10, 3);
