<?php
/**
 * Plugin Name: Text Animation Plugin
 * Description: Adds a shortcode to animate text with elegant letter-by-letter effects.
 * Version: 1.0.0
 * Requires at least: 6.9
 * Requires PHP: 7.4
 * Author: OpenAI Assistant
 * License: GPL-2.0-or-later
 * Text Domain: text-animation-plugin
 */

if (!defined('ABSPATH')) {
    exit;
}

define('TAP_VERSION', '1.0.0');
define('TAP_ASSETS_URL', plugin_dir_url(__FILE__) . 'assets/');

/**
 * Register frontend assets.
 */
function tap_register_assets(): void
{
    wp_register_style(
        'tap-text-animation',
        TAP_ASSETS_URL . 'text-animation.css',
        [],
        TAP_VERSION
    );

    wp_register_script(
        'tap-text-animation',
        TAP_ASSETS_URL . 'text-animation.js',
        [],
        TAP_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'tap_register_assets');

/**
 * Render shortcode output.
 *
 * @param array       $atts    Shortcode attributes.
 * @param string|null $content Enclosed content.
 * @return string
 */
function tap_render_text_animation_shortcode(array $atts, ?string $content = null): string
{
    $atts = shortcode_atts(
        [
            'text' => '',
            'effect' => 'fade',
            'speed' => 60,
        ],
        $atts,
        'text_animation'
    );

    $raw_text = $atts['text'] !== '' ? $atts['text'] : (string) $content;
    $text = wp_kses_post($raw_text);
    $label = wp_strip_all_tags($text);
    $effect = sanitize_key($atts['effect']);
    $speed = absint($atts['speed']);
    $speed = $speed > 0 ? $speed : 60;

    if ($text === '') {
        return '';
    }

    wp_enqueue_style('tap-text-animation');
    wp_enqueue_script('tap-text-animation');

    $uid = wp_unique_id('tap-text-animation-');

    return sprintf(
        '<span id="%1$s" class="tap-text-animation tap-text-animation--%2$s" data-text="%3$s" data-effect="%2$s" data-speed="%4$d" aria-label="%5$s"><span class="tap-text-animation__sr screen-reader-text">%5$s</span><span class="tap-text-animation__content" aria-hidden="true"></span></span>',
        esc_attr($uid),
        esc_attr($effect),
        esc_attr($text),
        $speed,
        esc_attr($label)
    );
}
add_shortcode('text_animation', 'tap_render_text_animation_shortcode');
