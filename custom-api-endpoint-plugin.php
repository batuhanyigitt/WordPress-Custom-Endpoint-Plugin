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
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
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
        if (is_array($data)) {
            return $data;
        } else {
            return false;
        }
    }

    private function output_user_data() {
        $users = $this->fetch_user_data();
        if ($users) {
            ?>
            <div class="container">
                <table>
                    <tr><th>ID</th><th>Name</th><th>Username</th></tr>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><a href="#" class="user-link" data-user-id="<?php echo esc_attr($user->id); ?>"><?php echo esc_html($user->id); ?></a></td>
                            <td><?php echo esc_html($user->name); ?></td>
                            <td><?php echo esc_html($user->username); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div id="user-details"></div>
            </div>
            <?php
        } else {
            echo 'Failed to fetch user data.';
        }
    }

    public function enqueue_scripts() {
        if (get_query_var('custom_api_endpoint')) {
            wp_enqueue_script('custom-api-endpoint-script', plugin_dir_url(__FILE__) . 'js/custom-api-endpoint-script.js', array('jquery'), null, true);
        }
    }
}

$wp_custom_api_endpoint_plugin = new WP_Custom_API_Endpoint_Plugin();
