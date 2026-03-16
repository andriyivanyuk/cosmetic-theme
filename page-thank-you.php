<?php

if (!defined('ABSPATH')) {
    exit;
}

$catalog_url = function_exists('de_shop_get_catalog_url')
    ? de_shop_get_catalog_url()
    : home_url('/catalog/');

get_header();
?>

<div id="page-content" class="de-thank-you-page">
    <div class="container">
        <div class="de-thank-you-wrap">
            <div class="de-thank-you-alert" role="status" aria-live="polite">
                <div class="de-thank-you-alert__icon" aria-hidden="true">
                    <i class="icon anm anm-truck-l"></i>
                </div>
                <div class="de-thank-you-alert__content">
                    <h1 class="de-thank-you-alert__title">
                        <?php esc_html_e('Дякуємо! Замовлення успішно оформлено.', 'de-shop-theme'); ?></h1>
                    <p class="de-thank-you-alert__text">
                        <?php esc_html_e('Ми вже отримали вашу заявку і зв\'яжемося з вами найближчим часом.', 'de-shop-theme'); ?>
                    </p>
                </div>
            </div>

            <div class="de-thank-you-actions">
                <a href="<?php echo esc_url($catalog_url); ?>"
                    class="btn"><?php esc_html_e('Продовжити покупки', 'de-shop-theme'); ?></a>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
