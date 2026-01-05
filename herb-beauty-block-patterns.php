<?php
/**
 * Plugin Name: Herb & Beauty Landing Page Patterns
 * Description: Block-based landing page patterns for herbs & spices and health & beauty products.
 * Version: 1.0.0
 * Requires at least: 6.9
 * Requires PHP: 7.4
 * Author: OpenAI Assistant
 * License: GPL-2.0-or-later
 * Text Domain: herb-beauty-patterns
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', function () {
    if (!function_exists('register_block_pattern_category') || !function_exists('register_block_pattern')) {
        return;
    }

    $categories = [
        'herb-beauty-landing' => [
            'label' => __('Herbs, Spices, Health & Beauty', 'herb-beauty-patterns'),
            'description' => __('Vibrant landing page layouts tailored for herbal, spice, and wellness brands.', 'herb-beauty-patterns'),
        ],
    ];

    foreach ($categories as $slug => $args) {
        if (!WP_Block_Pattern_Categories_Registry::get_instance()->is_registered($slug)) {
            register_block_pattern_category($slug, $args);
        }
    }

    $patterns = [
        'herbs-spices-landing' => __DIR__ . '/patterns/herbs-spices-landing.php',
        'health-beauty-landing' => __DIR__ . '/patterns/health-beauty-landing.php',
    ];

    foreach ($patterns as $name => $path) {
        if (file_exists($path)) {
            $pattern = require $path;
            if (is_array($pattern)) {
                register_block_pattern('herb-beauty-patterns/' . $name, $pattern);
            }
        }
    }
});
