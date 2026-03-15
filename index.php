<?php

if (!defined('ABSPATH')) {
    exit;
}

$has_header = '' !== locate_template('header.php', false, false);
$has_footer = '' !== locate_template('footer.php', false, false);

if ($has_header) {
    get_header();
} else {
    ?><!doctype html>
    <html <?php language_attributes(); ?>>

    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <?php
}
?>

    <main id="primary" class="site-main">
        <h1><?php esc_html_e('DE Shop Theme', 'de-shop-theme'); ?></h1>
        <p><?php esc_html_e('Theme skeleton is active and ready for frontend templates.', 'de-shop-theme'); ?></p>
    </main>

    <?php
    if ($has_footer) {
        get_footer();
    } else {
        wp_footer();
        ?>
    </body>

    </html>
    <?php
    }
