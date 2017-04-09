<?php
/**
 * Plugin Name:       Mailtrain
 * Plugin URI:        https://github.com/mailtrain-org/mailtrain-wordpress-plugin
 * Description:       A plugin to embed Mailtrain subscription forms.
 * Version:           0.1
 * Author:            Mailtrain.org
 * Author URI:        https://mailtrain.org
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * GitHub Plugin URI: https://github.com/mailtrain-org/mailtrain-wordpress-plugin
 * Requires WP:       4.4
 * Requires PHP:      5.4
 */

namespace Mailtrain;

defined('ABSPATH') || exit;

wp_register_script('mailtrain-subscription-widget', 'https://cdn.rawgit.com/mailtrain-org/mailtrain/v1.23.2/public/subscription/widget.js', [], '', true);

add_shortcode('mailtrain-subscription-widget', function($atts) {
    $atts = shortcode_atts([
        'url' => '',
        'fallback-text' => 'Subscribe to our list',
    ], $atts);

    $url = rtrim(trim($atts['url']), '/');
    $fallback = esc_attr($atts['fallback-text']);

    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return;
    }

    wp_enqueue_script('mailtrain-subscription-widget');
    return "<div data-mailtrain-subscription-widget data-url=\"{$url}/widget\"><a href=\"{$url}\">{$fallback}</a></div>";
});

add_action('widgets_init', function() {
    register_widget('Mailtrain\Subscription_Widget');
});

class Subscription_Widget extends \WP_Widget {
    public function __construct() {
        parent::__construct('mailtrain-subscription-widget', 'Mailtrain', [
            'classname' => 'mailtrain-widget',
            'description' => 'Mailtrain Subscription Widget'
        ]);
    }

    public function widget($args, $instance) {
        $before_title = $after_title = '';
        extract($args, EXTR_OVERWRITE);

        $title = apply_filters('widget_title', $instance['title']);
        $url = $instance['url'];
        $fallback = !empty($instance['fallback-text']) ? "fallback-text=\"{$instance['fallback-text']}\"" : '';

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return;
        }

        isset($before_widget) && print($before_widget);
        !empty($title) && print($before_title . esc_html($title) . $after_title);
        echo do_shortcode("[mailtrain-subscription-widget url=\"{$url}\" {$fallback}]");
        isset($after_widget) && print($after_widget);
    }

    public function form($instance) {
        $title = esc_attr($instance['title']);
        $url = esc_attr($instance['url']);
        $fallback = esc_attr($instance['fallback-text']);

        ?>
        <p>
            <label for="<?= $this->get_field_id('title') ?>"><?= 'Title:' ?></label>
            <input class="widefat" id="<?= $this->get_field_id('title') ?>" name="<?= $this->get_field_name('title') ?>" type="text" value="<?= $title ?>" />
        </p>
        <p>
            <label for="<?= $this->get_field_id('url') ?>"><?= 'URL:' ?></label>
            <input class="widefat" id="<?= $this->get_field_id('url') ?>" name="<?= $this->get_field_name('url') ?>" type="text" value="<?= $url ?>" />
        </p>
        <p>
            <label for="<?= $this->get_field_id('fallback-text') ?>"><?= 'Fallback Text:' ?></label>
            <input class="widefat" id="<?= $this->get_field_id('fallback-text') ?>" name="<?= $this->get_field_name('fallback-text') ?>" type="text" value="<?= $fallback ?>" />
        </p>
        <?php
    }
}
