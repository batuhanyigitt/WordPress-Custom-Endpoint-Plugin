<?php
/*
Plugin Name: Custom API Endpoint Plugin
Author: Ahmet Batuhan Yigit
*/

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class WP_Custom_API_Endpoint_Plugin {
    private $api_url;

    public function __construct() {
        $this->api_url = 'https://jsonplaceholder.typicode.com/users';
        add_action('init', array($this, 'create_custom_endpoint'));
        add_action('template_redirect', array($this, 'handle_custom_endpoint'));
    }

    public function create_custom_endpoint() {
        add_rewrite_rule('^custom-api-endpoint/?', 'index.php?custom_api_endpoint=1', 'top');
        add_rewrite_tag('%custom_api_endpoint%', '1');
    }

    public function handle_custom_endpoint() {
        if (get_query_var('custom_api_endpoint')) {
            $this->output_user_data();
            exit;
        }
    }

    private function fetch_user_data() {
        $response = wp_remote_get($this->api_url);
        if (is_wp_error($response)) {
            return false;
        }
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body);
        return $data;
    }

    private function output_user_data() {
        $users = $this->fetch_user_data();
        if ($users) {
            $html = '<table>';
            $html .= '<thead><tr><th>ID</th><th>Name</th><th>Username</th></tr></thead>';
            $html .= '<tbody>';
            foreach ($users as $user) {
                $html .= '<tr>';
                $html .= '<td>' . esc_html($user->id) . '</td>';
                $html .= '<td>' . esc_html($user->name) . '</td>';
                $html .= '<td>' . esc_html($user->username) . '</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody></table>';
            echo $html;
        } else {
            echo 'Failed to fetch user data.';
        }
    }
}

$wp_custom_api_endpoint_plugin = new WP_Custom_API_Endpoint_Plugin();
