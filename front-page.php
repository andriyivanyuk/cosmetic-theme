<?php
if (!defined('ABSPATH')) {
    exit;
}

$settings = function_exists('de_get_homepage_settings') ? de_get_homepage_settings() : [];
$recommended = function_exists('de_get_recommended_products') ? de_get_recommended_products() : [];
$new_arrivals = function_exists('de_get_new_arrivals_products') ? de_get_new_arrivals_products() : [];
$best_offers = function_exists('de_get_best_offers_products') ? de_get_best_offers_products() : [];
$featured = function_exists('de_get_featured_product') ? de_get_featured_product() : null;

$used_product_ids = [];

if ($featured instanceof \WP_Post) {
    $used_product_ids[(int) $featured->ID] = true;
}

$filter_unique_posts = static function (array $posts, array &$used): array {
    $result = [];

    foreach ($posts as $post_item) {
        if (!$post_item instanceof \WP_Post) {
            continue;
        }

        $post_id = (int) $post_item->ID;

        if (isset($used[$post_id])) {
            continue;
        }

        $used[$post_id] = true;
        $result[] = $post_item;
    }

    return $result;
};

$recommended = $filter_unique_posts($recommended, $used_product_ids);
$new_arrivals = $filter_unique_posts($new_arrivals, $used_product_ids);
$best_offers = $filter_unique_posts($best_offers, $used_product_ids);

$theme_uri = get_stylesheet_directory_uri();
$hero_default_image = $theme_uri . '/assets/images/slideshow-banners/home5-banner1.jpg';
$hero_image_url = $hero_default_image;

if (!empty($settings['hero_image_id'])) {
    $resolved_hero = wp_get_attachment_image_url(absint((int) $settings['hero_image_id']), 'full');

    if (is_string($resolved_hero) && '' !== $resolved_hero) {
        $hero_image_url = $resolved_hero;
    }
}

$hero_title = isset($settings['hero_title']) && (string) $settings['hero_title'] !== ''
    ? (string) $settings['hero_title']
    : 'The One';
$hero_subtitle = isset($settings['hero_subtitle']) && (string) $settings['hero_subtitle'] !== ''
    ? (string) $settings['hero_subtitle']
    : 'Complete your daring new look with the one';
$hero_button_text = isset($settings['hero_button_text']) && (string) $settings['hero_button_text'] !== ''
    ? (string) $settings['hero_button_text']
    : 'Shop now';
$hero_button_link = isset($settings['hero_button_link']) && (string) $settings['hero_button_link'] !== ''
    ? (string) $settings['hero_button_link']
    : '#';

$hero2_default_image = $theme_uri . '/assets/images/slideshow-banners/home5-banner2.jpg';
$hero2_image_url = $hero2_default_image;

if (!empty($settings['hero2_image_id'])) {
    $resolved_hero2 = wp_get_attachment_image_url(absint((int) $settings['hero2_image_id']), 'full');

    if (is_string($resolved_hero2) && '' !== $resolved_hero2) {
        $hero2_image_url = $resolved_hero2;
    }
}

$hero2_title = isset($settings['hero2_title']) && (string) $settings['hero2_title'] !== ''
    ? (string) $settings['hero2_title']
    : 'Editors Picks';
$hero2_subtitle = isset($settings['hero2_subtitle']) && (string) $settings['hero2_subtitle'] !== ''
    ? (string) $settings['hero2_subtitle']
    : 'The Editors Essential Mascara Guide';
$hero2_button_text = isset($settings['hero2_button_text']) && (string) $settings['hero2_button_text'] !== ''
    ? (string) $settings['hero2_button_text']
    : 'Замовити';
$hero2_button_link = isset($settings['hero2_button_link']) && (string) $settings['hero2_button_link'] !== ''
    ? (string) $settings['hero2_button_link']
    : '#';

$build_home_product_card = static function (\WP_Post $product, string $fallback_image): array {
    $product_id = (int) $product->ID;
    $meta_class = class_exists('\DE_Shop\\Products\\ProductMeta') ? '\\DE_Shop\\Products\\ProductMeta' : null;

    $sku = '';
    $price = '';
    $old_price = '';
    $currency = '';
    $show_price = true;
    $show_old_price = false;
    $description = '';

    if (is_string($meta_class)) {
        $sku = (string) $meta_class::get_sku($product_id);
        $price = (string) $meta_class::get_price($product_id);
        $old_price = (string) $meta_class::get_old_price($product_id);
        $currency = (string) $meta_class::get_currency($product_id);
        $show_price = (bool) $meta_class::should_show_price($product_id);
        $show_old_price = (bool) $meta_class::should_show_old_price($product_id);
        $description = (string) $meta_class::get_description($product_id);
    }

    $primary_image = get_the_post_thumbnail_url($product_id, 'large');
    $primary_image = is_string($primary_image) && '' !== $primary_image ? $primary_image : '';

    $hover_image = '';

    if (is_string($meta_class)) {
        $gallery_ids = $meta_class::get_gallery_ids($product_id);

        if ('' === $primary_image && !empty($gallery_ids)) {
            $gallery_primary = wp_get_attachment_image_url((int) $gallery_ids[0], 'large');

            if (is_string($gallery_primary) && '' !== $gallery_primary) {
                $primary_image = $gallery_primary;
            }
        }

        if (count($gallery_ids) > 1) {
            $gallery_hover = wp_get_attachment_image_url((int) $gallery_ids[1], 'large');

            if (is_string($gallery_hover) && '' !== $gallery_hover) {
                $hover_image = $gallery_hover;
            }
        }
    }

    if ('' === $primary_image) {
        $primary_image = $fallback_image;
    }

    if ('' === $hover_image) {
        $hover_image = $primary_image;
    }

    return [
        'id' => $product_id,
        'title' => get_the_title($product_id),
        'permalink' => get_permalink($product_id),
        'sku' => $sku,
        'primary_image' => $primary_image,
        'hover_image' => $hover_image,
        'price' => trim($price . ' ' . $currency),
        'old_price' => trim($old_price . ' ' . $currency),
        'show_price' => $show_price,
        'show_old_price' => $show_old_price,
        'description' => $description,
    ];
};

$recommended_cards = [];
foreach ($recommended as $product_item) {
    if ($product_item instanceof \WP_Post) {
        $recommended_cards[] = $build_home_product_card($product_item, $theme_uri . '/assets/images/cosmetic-product/product-image1.jpg');
    }
}

$new_arrivals_cards = [];
foreach ($new_arrivals as $product_item) {
    if ($product_item instanceof \WP_Post) {
        $new_arrivals_cards[] = $build_home_product_card($product_item, $theme_uri . '/assets/images/cosmetic-product/product-image6.jpg');
    }
}

$best_offers_cards = [];
foreach ($best_offers as $product_item) {
    if ($product_item instanceof \WP_Post) {
        $best_offers_cards[] = $build_home_product_card($product_item, $theme_uri . '/assets/images/cosmetic-product/product-image11.jpg');
    }
}

$featured_card = $featured instanceof \WP_Post
    ? $build_home_product_card($featured, $theme_uri . '/assets/images/cosmetic-product/single-product.jpg')
    : null;

get_header();
?>
<style>
    #page-content .de-hero-primary-slide .slideshow__overlay:before {
        opacity: 0;
    }

    #page-content .de-hero-primary-slide .slideshow__text-content {
        text-align: left;
        margin-top: 0;
        top: 45%;
        transform: translateY(-50%);
    }

    #page-content .de-hero-primary-slide .wrap-caption {
        width: min(52vw, 540px);
        max-width: 540px;
        padding: 20px clamp(24px, 3vw, 48px) 20px 0;
    }

    #page-content .de-hero-primary-slide .slideshow__title {
        font-size: clamp(40px, 4.3vw, 64px);
        line-height: 1.06;
        font-weight: 700;
        letter-spacing: -0.02em;
        margin-bottom: 16px;
        text-shadow: none;
    }

    #page-content .de-hero-primary-slide .slideshow__subtitle {
        font-size: clamp(15px, 1.5vw, 24px);
        line-height: 1.35;
        text-transform: none;
        margin-bottom: 24px;
        text-shadow: none;
        max-width: 500px;
    }

    #page-content .de-hero-primary-slide .btn {
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.04em;
        line-height: 1.1;
        padding: 14px 34px;
        margin-bottom: 22px;
    }

    #page-content .de-hero-primary-slide .slideshow__hero-points {
        list-style: none;
        margin: 0;
        padding: 0;
        max-width: 500px;
        opacity: 0.86;
    }

    #page-content .de-hero-primary-slide .slideshow__hero-points li {
        font-size: clamp(14px, 1.3vw, 21px);
        line-height: 1.45;
        margin-bottom: 7px;
        text-shadow: none;
    }

    #page-content .de-hero-primary-slide .slideshow__hero-points .icon {
        color: #fff;
        margin-right: 8px;
        font-size: clamp(14px, 1.2vw, 20px);
        vertical-align: middle;
    }

    #page-content .de-hero-secondary-slide .slideshow__overlay:before {
        opacity: 0;
    }

    #page-content .de-hero-secondary-slide .slideshow__text-content {
        text-align: left;
        margin-top: 0;
        top: 39%;
        transform: translateY(-50%);
    }

    #page-content .de-hero-secondary-slide .wrap-caption {
        width: min(56vw, 620px);
        max-width: 620px;
        padding: 20px clamp(24px, 3vw, 46px) 20px 0;
    }

    #page-content .de-hero-secondary-slide .slideshow__title {
        font-family: "Roboto Slab", Helvetica, Tahoma, Arial, serif;
        font-size: clamp(34px, 3.2vw, 58px);
        line-height: 1.1;
        font-weight: 500;
        letter-spacing: -0.012em;
        text-transform: none;
        max-width: 18.5ch;
        text-wrap: balance;
        margin-bottom: 16px;
        text-shadow: none;
    }

    #page-content .de-hero-secondary-slide .slideshow__subtitle {
        font-size: clamp(16px, 1.45vw, 24px);
        line-height: 1.38;
        text-transform: none;
        margin-bottom: 24px;
        max-width: 500px;
        text-shadow: none;
    }

    #page-content .de-hero-secondary-slide .btn {
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.04em;
        line-height: 1.1;
        padding: 14px 34px;
    }

    @media (max-width: 991px) {
        #page-content .de-hero-primary-slide .slideshow__text-content {
            top: 48%;
        }

        #page-content .de-hero-primary-slide .wrap-caption {
            width: min(92%, 520px);
            max-width: 520px;
            padding: 12px 8px;
        }

        #page-content .de-hero-primary-slide .btn {
            padding: 12px 28px;
        }

        #page-content .de-hero-primary-slide .slideshow__hero-points li {
            font-size: 16px;
            margin-bottom: 6px;
        }

        #page-content .de-hero-secondary-slide .slideshow__text-content {
            top: 41%;
        }

        #page-content .de-hero-secondary-slide .wrap-caption {
            width: min(92%, 560px);
            max-width: 560px;
            padding: 12px 8px;
        }

        #page-content .de-hero-secondary-slide .slideshow__title {
            font-size: clamp(30px, 7.1vw, 48px);
            margin-bottom: 12px;
        }

        #page-content .de-hero-secondary-slide .slideshow__subtitle {
            font-size: 16px;
            margin-bottom: 18px;
        }

        #page-content .de-hero-secondary-slide .btn {
            padding: 12px 28px;
        }
    }
</style>
<!--Body Content-->
<div id="page-content">
    <!--??????? slider-->
    <div class="slideshow slideshow-wrapper pb-section">
        <div class="home-slideshow">
            <div class="slide slideshow--medium de-hero-primary-slide">
                <div class="blur-up lazyload">
                    <img class="blur-up lazyload" data-src="<?php echo esc_url($hero_image_url); ?>"
                        src="<?php echo esc_url($hero_image_url); ?>" alt="<?php echo esc_attr($hero_title); ?>"
                        title="<?php echo esc_attr($hero_title); ?>" />
                    <div class="slideshow__text-wrap slideshow__overlay classic">
                        <div class="slideshow__text-content classic left">
                            <div class="container">
                                <div class="wrap-caption left">
                                    <h2 class="h1 mega-title slideshow__title"><?php echo esc_html($hero_title); ?></h2>
                                    <span
                                        class="mega-subtitle slideshow__subtitle"><?php echo esc_html($hero_subtitle); ?></span>
                                    <a href="<?php echo esc_url($hero_button_link); ?>"
                                        class="btn"><?php echo esc_html($hero_button_text); ?></a>
                                    <ul class="slideshow__hero-points">
                                        <li><i class="icon anm anm-check" aria-hidden="true"></i> Доставка по Україні
                                        </li>
                                        <li><i class="icon anm anm-check" aria-hidden="true"></i> Перевірена косметика
                                        </li>
                                        <li><i class="icon anm anm-check" aria-hidden="true"></i> Підходить для
                                            щоденного догляду</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide slideshow--medium de-hero-secondary-slide">
                <div class="blur-up lazyload">
                    <img class="blur-up lazyload" data-src="<?php echo esc_url($hero2_image_url); ?>"
                        src="<?php echo esc_url($hero2_image_url); ?>" alt="<?php echo esc_attr($hero2_title); ?>"
                        title="<?php echo esc_attr($hero2_title); ?>" />
                    <div class="slideshow__text-wrap slideshow__overlay classic top">
                        <div class="slideshow__text-content classic left">
                            <div class="container">
                                <div class="wrap-caption left">
                                    <h2 class="h1 mega-title slideshow__title"><?php echo esc_html($hero2_title); ?>
                                    </h2>
                                    <span
                                        class="mega-subtitle slideshow__subtitle"><?php echo esc_html($hero2_subtitle); ?></span>
                                    <a href="<?php echo esc_url($hero2_button_link); ?>"
                                        class="btn"><?php echo esc_html($hero2_button_text); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End ??????? slider-->

    <!--Collection Tab slider-->
    <div class="tab-slider-product section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-header text-center">
                        <h2 class="h2">Ми підібрали найкраще для вас</h2>
                        <p>Безкоштовна доставка для замовлень від $200</p>
                    </div>
                    <div class="tabs-listing">
                        <ul class="tabs clearfix">
                            <li class="active" rel="tab1">Рекомендуємо</li>
                            <li rel="tab2">Новинки</li>
                            <li rel="tab3">Найкращі пропозиції</li>
                        </ul>
                        <div class="tab_container">
                            <div id="tab1" class="tab_content grid-products">
                                <div class="productSlider">
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image1.jpg"
                                                    alt="image" title="product">
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image1-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image1-1.jpg"
                                                    alt="image" title="product">
                                                <!-- End hover image -->
                                                <!-- product label -->
                                                <div class="product-labels rectangular"><span
                                                        class="lbl on-sale">-16%</span> <span
                                                        class="lbl pr-label1">new</span></div>
                                                <!-- End product label -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- countdown start -->
                                            <div class="saleTime desktop" data-countdown="2022/03/01"></div>
                                            <!-- countdown end -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">?????? ??
                                                    ??????</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>
                                        <!-- end product image -->
                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">Edna Dress</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="old-price">$500.00</span>
                                                <span class="price">$600.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image2.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image2.jpg"
                                                    alt="image" title="product">
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image2-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image2-1.jpg"
                                                    alt="image" title="product">
                                                <!-- End hover image -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Select
                                                    Options</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>
                                        <!-- end product image -->

                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">Elastic Waist Dress</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="price">$748.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image3.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image3.jpg"
                                                    alt="image" title="product">
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image3-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image3-1.jpg"
                                                    alt="image" title="product">
                                                <!-- End hover image -->
                                                <!-- product label -->
                                                <div class="product-labels rectangular"><span
                                                        class="lbl pr-label2">???</span></div>
                                                <!-- End product label -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">?????? ??
                                                    ??????</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>
                                        <!-- end product image -->

                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">3/4 Sleeve Kimono Dress</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="price">$550.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image4.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image4.jpg"
                                                    alt="image" title="product" />
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image4-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image4-1.jpg"
                                                    alt="image" title="product" />
                                                <!-- End hover image -->
                                                <!-- product label -->
                                                <div class="product-labels"><span class="lbl on-sale">?????????</span>
                                                </div>
                                                <!-- End product label -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">?????? ??
                                                    ??????</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>
                                        <!-- end product image -->

                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">Cape Dress</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="old-price">$900.00</span>
                                                <span class="price">$788.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image5.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image5.jpg"
                                                    alt="image" title="product" />
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image5-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image5-1.jpg"
                                                    alt="image" title="product" />
                                                <!-- End hover image -->
                                                <!-- product label -->
                                                <div class="product-labels"><span class="lbl on-sale">?????????</span>
                                                </div>
                                                <!-- End product label -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Select
                                                    Options</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>
                                        <!-- end product image -->

                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">Paper Dress</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="price">$550.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                </div>
                            </div>
                            <div id="tab2" class="tab_content grid-products">
                                <div class="productSlider">
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image6.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image6.jpg"
                                                    alt="image" title="product">
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image6-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image6-1.jpg"
                                                    alt="image" title="product">
                                                <!-- End hover image -->
                                                <!-- product label -->
                                                <div class="product-labels rectangular"><span
                                                        class="lbl on-sale">-16%</span> <span
                                                        class="lbl pr-label1">new</span></div>
                                                <!-- End product label -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">?????? ??
                                                    ??????</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>
                                        <!-- end product image -->

                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">Zipper Jacket</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="price">$788.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image7.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image7.jpg"
                                                    alt="image" title="product">
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image7-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image7-1.jpg"
                                                    alt="image" title="product">
                                                <!-- End hover image -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Select
                                                    Options</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>
                                        <!-- end product image -->

                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">Zipper Jacket</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="price">$748.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image8.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image8.jpg"
                                                    alt="image" title="product">
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image8-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image8-1.jpg"
                                                    alt="image" title="product">
                                                <!-- End hover image -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">?????? ??
                                                    ??????</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>

                                        <!-- end product image -->

                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">Workers Shirt Jacket</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="price">$238.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image9.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image9.jpg"
                                                    alt="image" title="product">
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image9-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image9-1.jpg"
                                                    alt="image" title="product">
                                                <!-- End hover image -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">?????? ??
                                                    ??????</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>
                                        <!-- end product image -->

                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">Watercolor Sport Jacket in Brown/Blue</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="price">$348.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image10.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image10.jpg"
                                                    alt="image" title="product">
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image10-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image10-1.jpg"
                                                    alt="image" title="product">
                                                <!-- End hover image -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">?????? ??
                                                    ??????</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>
                                        <!-- end product image -->

                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">Washed Wool Blazer</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="price">$1,078.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                </div>
                            </div>
                            <div id="tab3" class="tab_content grid-products">
                                <div class="productSlider">
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image11.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image11.jpg"
                                                    alt="image" title="product">
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image11-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image11-1.jpg"
                                                    alt="image" title="product">
                                                <!-- End hover image -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">?????? ??
                                                    ??????</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>
                                        <!-- end product image -->

                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">Azur Bracelet in Blue Azurite</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="price">$168.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image12.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image12.jpg"
                                                    alt="image" title="product">
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image12-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image12-1.jpg"
                                                    alt="image" title="product">
                                                <!-- End hover image -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Select
                                                    Options</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>
                                        <!-- end product image -->

                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">Bi-Goutte Earrings</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="price">$58.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image13.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image13.jpg"
                                                    alt="image" title="product">
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image13-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image13-1.jpg"
                                                    alt="image" title="product">
                                                <!-- End hover image -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">?????? ??
                                                    ??????</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>

                                        <!-- end product image -->

                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">Ashton Necklace</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="price">$228.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image14.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image14.jpg"
                                                    alt="image" title="product">
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image14-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image14-1.jpg"
                                                    alt="image" title="product">
                                                <!-- End hover image -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">?????? ??
                                                    ??????</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>
                                        <!-- end product image -->

                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">Ara Ring</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="price">$198.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                    <div class="col-12 item">
                                        <!-- start product image -->
                                        <div class="product-image">
                                            <!-- start product image -->
                                            <a href="#">
                                                <!-- image -->
                                                <img class="primary blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image15.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image15.jpg"
                                                    alt="image" title="product">
                                                <!-- End image -->
                                                <!-- Hover image -->
                                                <img class="hover blur-up lazyload"
                                                    data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image15-1.jpg"
                                                    src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/product-image15-1.jpg"
                                                    alt="image" title="product">
                                                <!-- End hover image -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">?????? ??
                                                    ??????</button>
                                            </form>
                                            <div class="button-set">
                                                <a href="javascript:void(0)" title="Quick View"
                                                    class="quick-view-popup quick-view" data-toggle="modal"
                                                    data-target="#content_quickview">
                                                    <i class="icon anm anm-search-plus-r"></i>
                                                </a>
                                                <div class="wishlist-btn">
                                                    <a class="wishlist add-to-wishlist" href="wishlist.html">
                                                        <i class="icon anm anm-heart-l"></i>
                                                    </a>
                                                </div>
                                                <div class="compare-btn">
                                                    <a class="compare add-to-compare" href="compare.html"
                                                        title="Add to Compare">
                                                        <i class="icon anm anm-random-r"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- end product button -->
                                        </div>
                                        <!-- end product image -->

                                        <!--start product details -->
                                        <div class="product-details text-center">
                                            <!-- product name -->
                                            <div class="product-name">
                                                <a href="#">Ara Ring</a>
                                            </div>
                                            <!-- End product name -->
                                            <!-- product price -->
                                            <div class="product-price">
                                                <span class="price">$198.00</span>
                                            </div>
                                            <!-- End product price -->
                                        </div>
                                        <!-- End product details -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Collection Tab slider-->

    <!--Featured Column-->
    <div class="section featured-column">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-header text-center">
                        <h2 class="h2">Найкращі б'юті-пропозиції для вас!</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row js-home-featured-offers"></div>
                </div>
            </div>
        </div>
    </div>
    <!--End Featured Column-->

    <!--Parallax Section-->
    <div class="section">
        <div class="hero hero--large hero__overlay bg-size">
            <img class="bg-img blur-up"
                src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/parallax-banners/cosmetic-parallax.jpg"
                alt="" />
            <div class="hero__inner">
                <div class="container">
                    <div class="wrap-text center text-large font-bold">
                        <h2 class="h2 mega-title">Надзвичайна м'якість</h2>
                        <div class="rte-setting mega-subtitle">Ви не повірите, наскільки неймовірною<br> є ця помада!
                        </div>
                        <a href="#" class="btn">Замовте набір сьогодні</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Parallax Section-->

    <!--????? Single-->
    <div class="section product-single product-template__container">
        <div class="container">
            <div class="product-single-wrap">
                <div class="row display-table">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 display-table-cell">
                        <a href="#" class="js-featured-product-link">
                            <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/single-product.jpg"
                                alt="" class="product-featured-img" />
                        </a>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 display-table-cell">
                        <div class="product-single__meta">
                            <h2 class="grid_item-title h2">Суперпропозиція</h2>
                            <h2 class="product-single__title h4">
                                <a href="#">Makeup &amp; Cosmetics Travel Bag</a>
                            </h2>
                            <p class="product-single__price">
                                <span class="money">$15.79</span>
                                <span class="product-price__price product-price__sale product-price__sale--single">
                                    <span class="money">$9.21</span>
                                </span>
                            </p>
                            <div class="product-single__description rte">The perfect makeup bag for every personality!
                                These fun makeup bags will hold all your cosmetic goodies! It can hold all your
                                essentials including a full sized makeup palette &amp; brushes! Highlights:Zipper
                                Closure</div>
                            <!-- ????? Action -->
                            <div class="product-action clearfix">
                                <div class="product-form__item--quantity">
                                    <div class="wrapQtyBtn">
                                        <div class="qtyField">
                                            <a class="qtyBtn minus" href="javascript:void(0);"><i
                                                    class="fa anm anm-minus-r" aria-hidden="true"></i></a>
                                            <input type="text" id="Quantity" name="quantity" value="1"
                                                class="product-form__input qty">
                                            <a class="qtyBtn plus" href="javascript:void(0);"><i
                                                    class="fa anm anm-plus-r" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-form__item--submit">
                                    <button type="button" name="add" class="btn product-form__cart-submit">
                                        <span>Замовити</span>
                                    </button>
                                </div>
                                <div class="display-table shareRow">
                                    <div class="display-table-cell">
                                        <div class="wishlist-btn">
                                            <a class="wishlist add-to-wishlist" href="#"
                                                title="Додати до списку бажань"><i class="icon anm anm-heart-l"
                                                    aria-hidden="true"></i> <span>Додати до списку бажань</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End ????? Action -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End ????? Single-->

    <!--Store Feature-->
    <div class="store-feature section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="display-table store-info">
                        <li class="display-table-cell">
                            <i class="icon anm anm-truck-l"></i>
                            <h5>ДОСТАВКА ПО ВСІЙ УКРАЇНІ</h5>
                            <span class="sub-text">
                                Відправляємо щодня Новою поштою та Укрпоштою
                            </span>
                        </li>
                        <li class="display-table-cell">
                            <i class="icon anm anm-money-bill-ar"></i>
                            <h5>ГАРАНТІЯ ПОВЕРНЕННЯ</h5>
                            <span class="sub-text">
                                Обмін або повернення протягом 14 днів
                            </span>
                        </li>
                        <li class="display-table-cell">
                            <i class="icon anm anm-comments-l"></i>
                            <h5>ПІДТРИМКА УКРАЇНСЬКОЮ</h5>
                            <span class="sub-text">
                                Допоможемо з вибором у чаті щодня з 9:00 до 21:00
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--End Store Feature-->

</div>
<!--End Body Content-->
<script>
    (function () {
        var recommended = <?php echo wp_json_encode($recommended_cards, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?> || [];
        var newArrivals = <?php echo wp_json_encode($new_arrivals_cards, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?> || [];
        var bestOffers = <?php echo wp_json_encode($best_offers_cards, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?> || [];
        var featured = <?php echo wp_json_encode($featured_card, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

        var escapeHtml = function (value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        };

        var buildCardHtml = function (card) {
            var oldPrice = card.show_old_price && card.old_price
                ? '<span class="old-price">' + escapeHtml(card.old_price) + '</span>'
                : '';
            var price = card.show_price && card.price
                ? '<span class="price">' + escapeHtml(card.price) + '</span>'
                : '<span class="price">Ціну уточнюйте</span>';

            return '' +
                '<div class="col-12 item">' +
                '  <div class="product-image">' +
                '    <a href="' + escapeHtml(card.permalink) + '">' +
                '      <img class="primary blur-up lazyload" data-src="' + escapeHtml(card.primary_image) + '" src="' + escapeHtml(card.primary_image) + '" alt="' + escapeHtml(card.title) + '" title="' + escapeHtml(card.title) + '">' +
                '      <img class="hover blur-up lazyload" data-src="' + escapeHtml(card.hover_image) + '" src="' + escapeHtml(card.hover_image) + '" alt="' + escapeHtml(card.title) + '" title="' + escapeHtml(card.title) + '">' +
                '    </a>' +
                '    <div class="button-set">' +
                '      <a href="javascript:void(0)" title="Швидкий перегляд" class="quick-view-popup quick-view js-open-quickview-home" data-toggle="modal" data-target="#content_quickview" data-product-id="' + escapeHtml(card.id) + '" data-product-title="' + escapeHtml(card.title) + '" data-product-sku="' + escapeHtml(card.sku || '-') + '" data-product-image="' + escapeHtml(card.primary_image) + '" data-product-price="' + escapeHtml(card.price) + '" data-product-link="' + escapeHtml(card.permalink) + '">' +
                '        <i class="icon anm anm-search-plus-r"></i>' +
                '      </a>' +
                '    </div>' +
                '    <form class="variants add" action="' + escapeHtml(card.permalink) + '" method="post" onclick="window.location.href=\'' + escapeHtml(card.permalink) + '\'">' +
                '      <button class="btn btn-addto-cart" type="button" tabindex="0">Замовити</button>' +
                '    </form>' +
                '  </div>' +
                '  <div class="product-details text-center">' +
                '    <div class="product-name"><a href="' + escapeHtml(card.permalink) + '">' + escapeHtml(card.title) + '</a></div>' +
                '    <div class="product-price">' + oldPrice + price + '</div>' +
                '  </div>' +
                '</div>';
        };

        var renderTab = function (tabSelector, cards) {
            var slider = document.querySelector(tabSelector + ' .productSlider');

            if (!slider) {
                return;
            }

            if (!Array.isArray(cards) || cards.length === 0) {
                slider.innerHTML = '<p class="text-center">У цьому розділі поки немає товарів.</p>';
                return;
            }

            slider.innerHTML = cards.map(buildCardHtml).join('');
        };

        renderTab('#tab1', recommended);
        renderTab('#tab2', newArrivals);
        renderTab('#tab3', bestOffers);

        var toPlainText = function (value) {
            var temp = document.createElement('div');
            temp.innerHTML = String(value || '');

            return (temp.textContent || temp.innerText || '')
                .replace(/\s+/g, ' ')
                .trim();
        };

        var buildFeaturedOfferHtml = function (card) {
            var description = toPlainText(card.description || '');

            if (!description) {
                description = 'Оберіть цей товар у розділі найкращих пропозицій.';
            }

            return '' +
                '<div class="col-12 col-sm-6 col-md-4 col-lg-4 text-center">' +
                '  <p>' +
                '    <a href="' + escapeHtml(card.permalink) + '">' +
                '      <img class="blur-up lazyload" data-src="' + escapeHtml(card.primary_image) + '" src="' + escapeHtml(card.primary_image) + '" alt="' + escapeHtml(card.title) + '">' +
                '    </a>' +
                '  </p>' +
                '  <h3 class="h4"><a href="' + escapeHtml(card.permalink) + '">' + escapeHtml(card.title) + '</a></h3>' +
                '  <a href="' + escapeHtml(card.permalink) + '" class="btn no-border">Замовити</a>' +
                '</div>';
        };

        var renderFeaturedOffers = function (cards) {
            var container = document.querySelector('.js-home-featured-offers');

            if (!container) {
                return;
            }

            if (!Array.isArray(cards) || cards.length === 0) {
                container.innerHTML = '<div class="col-12"><p class="text-center">У цьому розділі поки немає товарів.</p></div>';
                return;
            }

            container.innerHTML = cards.slice(0, 3).map(buildFeaturedOfferHtml).join('');
        };

        renderFeaturedOffers(bestOffers);

        var addToCart = function (product) {
            if (!product || !product.id) {
                return;
            }

            var cart = [];

            try {
                var saved = localStorage.getItem('de_cart');

                if (saved) {
                    var parsed = JSON.parse(saved);

                    if (Array.isArray(parsed)) {
                        cart = parsed;
                    }
                }
            } catch (_err) {
                cart = [];
            }

            var existingItem = null;

            cart.forEach(function (item) {
                if (item && String(item.id) === String(product.id)) {
                    existingItem = item;
                }
            });

            if (existingItem) {
                var currentQty = parseInt(existingItem.qty, 10);
                existingItem.qty = Number.isNaN(currentQty) ? 1 : currentQty + 1;
            } else {
                cart.push({
                    id: String(product.id),
                    title: String(product.title || ''),
                    price: String(product.price || ''),
                    image: String(product.image || ''),
                    qty: 1
                });
            }

            localStorage.setItem('de_cart', JSON.stringify(cart));
            window.dispatchEvent(new Event('de:cart-updated'));

            if (window.deShopCart && typeof window.deShopCart.showToast === 'function') {
                window.deShopCart.showToast('Додано до кошика: ' + String(product.title || 'Товар'));
            }
        };

        var getCardQuickviewData = function (trigger) {
            var item = trigger ? trigger.closest('.item') : null;
            var idFromData = trigger ? (trigger.getAttribute('data-product-id') || '') : '';
            var titleFromData = trigger ? (trigger.getAttribute('data-product-title') || '') : '';
            var skuFromData = trigger ? (trigger.getAttribute('data-product-sku') || '') : '';
            var imageFromData = trigger ? (trigger.getAttribute('data-product-image') || '') : '';
            var priceFromData = trigger ? (trigger.getAttribute('data-product-price') || '') : '';
            var linkFromData = trigger ? (trigger.getAttribute('data-product-link') || '') : '';

            var id = idFromData;
            var title = titleFromData;
            var link = linkFromData;
            var image = imageFromData;
            var price = priceFromData;

            if (item) {
                var nameLink = item.querySelector('.product-name a');
                var priceNode = item.querySelector('.product-price .price');

                if (!id && nameLink) {
                    var href = nameLink.getAttribute('href') || '';
                    var idMatch = href.match(/\/(\d+)\/?$/);

                    if (idMatch && idMatch[1]) {
                        id = idMatch[1];
                    }
                }

                if (!title && nameLink) {
                    title = (nameLink.textContent || '').trim();
                }

                if (!link && nameLink && nameLink.getAttribute('href')) {
                    link = nameLink.getAttribute('href');
                }

                if (!image) {
                    var primaryImage = item.querySelector('.product-image img.primary');

                    if (primaryImage) {
                        image = primaryImage.getAttribute('src') || primaryImage.getAttribute('data-src') || '';
                    }
                }

                if (!price && priceNode) {
                    price = (priceNode.textContent || '').trim();
                }
            }

            return {
                id: id,
                title: title || 'Швидкий перегляд товару',
                sku: skuFromData || '-',
                image: image,
                price: price,
                link: link || '#'
            };
        };

        document.addEventListener('click', function (event) {
            var trigger = event.target.closest('.tab-slider-product .quick-view-popup');

            if (!trigger) {
                return;
            }

            event.preventDefault();

            var data = getCardQuickviewData(trigger);
            var quickviewTitle = document.getElementById('de-quickview-title');
            var quickviewSku = document.getElementById('de-quickview-sku');
            var quickviewImage = document.getElementById('de-quickview-image');
            var quickviewButton = document.querySelector('.js-quickview-add-to-request');

            if (quickviewTitle) {
                quickviewTitle.textContent = data.title;
            }

            if (quickviewSku) {
                quickviewSku.textContent = data.sku;
            }

            if (quickviewImage && data.image) {
                quickviewImage.setAttribute('src', data.image);
                quickviewImage.setAttribute('alt', data.title);
            }

            if (quickviewButton) {
                var buttonLabel = quickviewButton.querySelector('span');

                quickviewButton.setAttribute('data-product-id', data.id || '');
                quickviewButton.setAttribute('data-product-title', data.title || '');
                quickviewButton.setAttribute('data-product-price', data.price || '');
                quickviewButton.setAttribute('data-product-image', data.image || '');
                quickviewButton.setAttribute('data-product-link', data.link);

                if (buttonLabel) {
                    buttonLabel.textContent = 'Замовити';
                }
            }

            if (window.jQuery && window.jQuery.fn && window.jQuery.fn.modal) {
                window.jQuery('#content_quickview').modal('show');
            }
        });

        document.addEventListener('click', function (event) {
            var quickviewButton = event.target.closest('.js-quickview-add-to-request');

            if (!quickviewButton) {
                return;
            }

            event.preventDefault();

            addToCart({
                id: quickviewButton.getAttribute('data-product-id') || '',
                title: quickviewButton.getAttribute('data-product-title') || '',
                price: quickviewButton.getAttribute('data-product-price') || '',
                image: quickviewButton.getAttribute('data-product-image') || ''
            });

            if (window.jQuery && window.jQuery.fn && window.jQuery.fn.modal) {
                window.jQuery('#content_quickview').modal('hide');
            }
        });

        if (featured && featured.permalink) {
            var section = document.querySelector('.section.product-single.product-template__container');

            if (section) {
                var image = section.querySelector('.product-featured-img');
                var imageLink = section.querySelector('.js-featured-product-link');
                var titleLink = section.querySelector('.product-single__title a');
                var priceWrap = section.querySelector('.product-single__price');
                var description = section.querySelector('.product-single__description');
                var actionButton = section.querySelector('.product-form__cart-submit');
                var actionButtonText = section.querySelector('.product-form__cart-submit span');
                var quantityWrap = section.querySelector('.product-form__item--quantity');
                var wishlistWrap = section.querySelector('.shareRow');

                if (image) {
                    image.setAttribute('src', featured.primary_image || image.getAttribute('src') || '');
                    image.setAttribute('alt', featured.title || '');
                }

                if (titleLink) {
                    titleLink.textContent = featured.title || titleLink.textContent;
                    titleLink.setAttribute('href', featured.permalink);
                }

                if (imageLink) {
                    imageLink.setAttribute('href', featured.permalink);
                    imageLink.setAttribute('title', featured.title || 'Перейти до товару');
                }

                if (priceWrap) {
                    var oldPart = featured.show_old_price && featured.old_price
                        ? '<span class="money">' + escapeHtml(featured.old_price) + '</span>'
                        : '';
                    var pricePart = featured.show_price && featured.price
                        ? '<span class="money">' + escapeHtml(featured.price) + '</span>'
                        : '<span class="money">Ціну уточнюйте</span>';

                    priceWrap.innerHTML = oldPart + '<span class="product-price__price product-price__sale product-price__sale--single">' + pricePart + '</span>';
                }

                if (description && featured.description) {
                    description.textContent = featured.description;
                }

                if (actionButtonText) {
                    actionButtonText.textContent = 'Замовити';
                }

                if (actionButton) {
                    actionButton.addEventListener('click', function (event) {
                        event.preventDefault();

                        addToCart({
                            id: featured.id,
                            title: featured.title,
                            price: featured.price,
                            image: featured.primary_image
                        });
                    });
                }

                if (quantityWrap) {
                    quantityWrap.style.display = 'none';
                }

                if (wishlistWrap) {
                    wishlistWrap.style.disp
                    lay = 'none';
                }
            }
        }
    })();
</script>
<?php
get_footer();


