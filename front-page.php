<?php
if (!defined('ABSPATH')) {
    exit;
}

$settings = function_exists('de_get_homepage_settings') ? de_get_homepage_settings() : [];
$recommended = function_exists('de_get_recommended_products') ? de_get_recommended_products() : [];
$new_arrivals = function_exists('de_get_new_arrivals_products') ? de_get_new_arrivals_products() : [];
$best_offers = function_exists('de_get_best_offers_products') ? de_get_best_offers_products() : [];
$featured = function_exists('de_get_featured_product') ? de_get_featured_product() : null;

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

$build_home_product_card = static function (\WP_Post $product, string $fallback_image): array {
    $product_id = (int) $product->ID;
    $meta_class = class_exists('\DE_Shop\\Products\\ProductMeta') ? '\\DE_Shop\\Products\\ProductMeta' : null;

    $price = '';
    $old_price = '';
    $currency = '';
    $show_price = true;
    $show_old_price = false;
    $description = '';

    if (is_string($meta_class)) {
        $price = (string) $meta_class::get_price($product_id);
        $old_price = (string) $meta_class::get_old_price($product_id);
        $currency = (string) $meta_class::get_currency($product_id);
        $show_price = (bool) $meta_class::should_show_price($product_id);
        $show_old_price = (bool) $meta_class::should_show_old_price($product_id);
        $description = (string) $meta_class::get_description($product_id);
    }

    $primary_image = get_the_post_thumbnail_url($product_id, 'large');
    $primary_image = is_string($primary_image) && '' !== $primary_image ? $primary_image : $fallback_image;

    $hover_image = $primary_image;

    if (is_string($meta_class)) {
        $gallery_ids = $meta_class::get_gallery_ids($product_id);

        if (!empty($gallery_ids)) {
            $gallery_image = wp_get_attachment_image_url((int) $gallery_ids[0], 'large');

            if (is_string($gallery_image) && '' !== $gallery_image) {
                $hover_image = $gallery_image;
            }
        }
    }

    return [
        'id' => $product_id,
        'title' => get_the_title($product_id),
        'permalink' => get_permalink($product_id),
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
<!--Body Content-->
<div id="page-content">
    <!--??????? slider-->
    <div class="slideshow slideshow-wrapper pb-section">
        <div class="home-slideshow">
            <div class="slide slideshow--medium">
                <div class="blur-up lazyload">
                    <img class="blur-up lazyload" data-src="<?php echo esc_url($hero_image_url); ?>"
                        src="<?php echo esc_url($hero_image_url); ?>" alt="<?php echo esc_attr($hero_title); ?>"
                        title="<?php echo esc_attr($hero_title); ?>" />
                    <div class="slideshow__text-wrap slideshow__overlay classic middle">
                        <div class="slideshow__text-content classic left">
                            <div class="container">
                                <div class="wrap-caption left">
                                    <h2 class="h1 mega-title slideshow__title"><?php echo esc_html($hero_title); ?></h2>
                                    <span
                                        class="mega-subtitle slideshow__subtitle"><?php echo esc_html($hero_subtitle); ?></span>
                                    <a href="<?php echo esc_url($hero_button_link); ?>"
                                        class="btn"><?php echo esc_html($hero_button_text); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide slideshow--medium">
                <div class="blur-up lazyload">
                    <img class="blur-up lazyload"
                        data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/slideshow-banners/home5-banner2.jpg"
                        src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/slideshow-banners/home5-banner2.jpg"
                        alt="Editors Picks" title="Editors Picks" />
                    <div class="slideshow__text-wrap slideshow__overlay classic top">
                        <div class="slideshow__text-content classic top">
                            <div class="container">
                                <div class="wrap-caption center">
                                    <h2 class="h1 mega-title slideshow__title">Editors Picks</h2>
                                    <span class="mega-subtitle slideshow__subtitle">The Editors Essential Mascara
                                        Guide</span>
                                    <span class="btn">??????? now</span>
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
                        <h2 class="h2">?? ????????? ???????? ??? ???</h2>
                        <p>??????????? ???????? ??? ????????? ??? $200</p>
                    </div>
                    <div class="tabs-listing">
                        <ul class="tabs clearfix">
                            <li class="active" rel="tab1">????????????</li>
                            <li rel="tab2">???????</li>
                            <li rel="tab3">???????? ??????????</li>
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
                        <h2 class="h2">???????? ?'???-?????????? ??? ???!</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <!--Featured Item-->
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 text-center">
                    <p>
                        <a href="#">
                            <img class="blur-up lazyload"
                                data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/collection/cosmetic1.jpg"
                                src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/collection/cosmetic1.jpg"
                                alt="feature-row__image">
                        </a>
                    </p>
                    <h3 class="h4"><a href="#">????????? ?????????</a></h3>
                    <div class="rte-setting">
                        <p><strong>There is nothing more you can ask for. </strong>Gives your skin a natural glow with
                            matte finish</p>
                    </div>
                    <a href="#" class="btn no-border">??????? Now</a>
                </div>
                <!--End Featured Item-->
                <!--Featured Item-->
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 text-center">
                    <p>
                        <a href="#">
                            <img class="blur-up lazyload"
                                data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/collection/cosmetic2.jpg"
                                src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/collection/cosmetic2.jpg"
                                alt="feature-row__image">
                        </a>
                    </p>
                    <h3 class="h4"><a href="#">????? ??? ???</a></h3>
                    <div class="rte-setting">
                        <p>Enjoy the stay. Love the Shine Logn Lasting Ultramatte perfact lip color</p>
                    </div>
                    <a href="#" class="btn no-border">??????? ???? Arrivals</a>
                </div>
                <!--End Featured Item-->
                <!--Featured Item-->
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 text-center">
                    <p>
                        <a href="#">
                            <img class="blur-up lazyload"
                                data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/collection/cosmetic3.jpg"
                                src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/collection/cosmetic3.jpg"
                                alt="feature-row__image">
                        </a>
                    </p>
                    <h3 class="h4"><a href="#">???????? ??? ????</a></h3>
                    <div class="rte-setting">
                        <p>Wing it with perfection. Dramatic wing perfection. Fine tip liquid eyeliner stay long lasting
                        </p>
                    </div>
                    <a href="#" class="btn no-border">Buy Now</a>
                </div>
                <!--End Featured Item-->
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
                        <h2 class="h2 mega-title">??????????? ?'??????</h2>
                        <div class="rte-setting mega-subtitle">?? ?? ????????, ????????? ???????????<br> ? ?? ??????!
                        </div>
                        <a href="#" class="btn">??????? ????? ????????</a>
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
                        <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/cosmetic-product/single-product.jpg"
                            alt="" class="product-featured-img" />
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 display-table-cell">
                        <div class="product-single__meta">
                            <h2 class="grid_item-title h2">???????????????</h2>
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
                                        <span>?????? ? ?????</span>
                                    </button>
                                </div>
                                <div class="display-table shareRow">
                                    <div class="display-table-cell">
                                        <div class="wishlist-btn">
                                            <a class="wishlist add-to-wishlist" href="#"
                                                title="?????? ?? ?????? ??????"><i class="icon anm anm-heart-l"
                                                    aria-hidden="true"></i> <span>?????? ?? ?????? ??????</span></a>
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
                            <h5>Free Shipping Worldwide</h5>
                            <span class="sub-text">
                                Diam augue augue in fusce voluptatem
                            </span>
                        </li>
                        <li class="display-table-cell">
                            <i class="icon anm anm-money-bill-ar"></i>
                            <h5>Money Back Guarantee</h5>
                            <span class="sub-text">
                                Use this text to display your store information
                            </span>
                        </li>
                        <li class="display-table-cell">
                            <i class="icon anm anm-comments-l"></i>
                            <h5>24/7 Help Center</h5>
                            <span class="sub-text">
                                Use this text to display your store information
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
                : '<span class="price">Price on request</span>';

            return '' +
                '<div class="col-12 item">' +
                '  <div class="product-image">' +
                '    <a href="' + escapeHtml(card.permalink) + '">' +
                '      <img class="primary blur-up lazyload" data-src="' + escapeHtml(card.primary_image) + '" src="' + escapeHtml(card.primary_image) + '" alt="' + escapeHtml(card.title) + '" title="' + escapeHtml(card.title) + '">' +
                '      <img class="hover blur-up lazyload" data-src="' + escapeHtml(card.hover_image) + '" src="' + escapeHtml(card.hover_image) + '" alt="' + escapeHtml(card.title) + '" title="' + escapeHtml(card.title) + '">' +
                '    </a>' +
                '    <form class="variants add" action="' + escapeHtml(card.permalink) + '" method="post" onclick="window.location.href=\'' + escapeHtml(card.permalink) + '\'">' +
                '      <button class="btn btn-addto-cart" type="button" tabindex="0">View Product</button>' +
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
                slider.innerHTML = '<p class="text-center">No products selected for this section yet.</p>';
                return;
            }

            slider.innerHTML = cards.map(buildCardHtml).join('');
        };

        renderTab('#tab1', recommended);
        renderTab('#tab2', newArrivals);
        renderTab('#tab3', bestOffers);

        if (featured && featured.permalink) {
            var section = document.querySelector('.section.product-single.product-template__container');

            if (section) {
                var image = section.querySelector('.product-featured-img');
                var titleLink = section.querySelector('.product-single__title a');
                var priceWrap = section.querySelector('.product-single__price');
                var description = section.querySelector('.product-single__description');

                if (image) {
                    image.setAttribute('src', featured.primary_image || image.getAttribute('src') || '');
                    image.setAttribute('alt', featured.title || '');
                }

                if (titleLink) {
                    titleLink.textContent = featured.title || titleLink.textContent;
                    titleLink.setAttribute('href', featured.permalink);
                }

                if (priceWrap) {
                    var oldPart = featured.show_old_price && featured.old_price
                        ? '<span class="money">' + escapeHtml(featured.old_price) + '</span>'
                        : '';
                    var pricePart = featured.show_price && featured.price
                        ? '<span class="money">' + escapeHtml(featured.price) + '</span>'
                        : '<span class="money">Price on request</span>';

                    priceWrap.innerHTML = oldPart + '<span class="product-price__price product-price__sale product-price__sale--single">' + pricePart + '</span>';
                }

                if (description && featured.description) {
                    description.textContent = featured.description;
                }
            }
        }
    })();
</script>
<?php
get_footer();


