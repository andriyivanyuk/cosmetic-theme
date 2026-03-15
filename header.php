<?php
if (!defined('ABSPATH')) {
    exit;
}

$catalog_url = function_exists('de_shop_get_catalog_url')
    ? de_shop_get_catalog_url()
    : home_url('/catalog/');

$order_url = function_exists('de_shop_get_order_url')
    ? de_shop_get_order_url()
    : home_url('/request/');

$is_home = is_front_page();
$is_catalog = is_page('catalog') || is_page_template('page-catalog.php') || is_post_type_archive('de_product');
$body_classes = ['belle'];
$header_wrap_classes = 'header-wrap animated d-flex';
$site_nav_classes = 'site-nav medium center hidearrow';

if ($is_home) {
    $body_classes[] = 'template-index';
    $body_classes[] = 'home5-cosmetic';
    $header_wrap_classes = 'header-wrap classicHeader animated d-flex';
    $site_nav_classes = 'site-nav medium right hidearrow';
} elseif ($is_catalog) {
    $body_classes[] = 'template-collection';
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/favicon.png" />
    <?php wp_head(); ?>
</head>

<body <?php body_class($body_classes); ?>>
    <?php wp_body_open(); ?>
    <div id="pre-loader">
        <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/loader.gif" alt="Завантаження" />
    </div>

    <div class="pageWrapper">
        <!--Search Form Drawer-->
        <div class="search">
            <div class="search__form">
                <form class="search-bar__form" action="#">
                    <button class="go-btn search__button" type="submit"><i class="icon anm anm-search-l"></i></button>
                    <input class="search__input" type="search" name="q" value="" placeholder="Пошук по магазину..."
                        aria-label="Пошук" autocomplete="off">
                </form>
                <button type="button" class="search-trigger close-btn"><i class="anm anm-times-l"></i></button>
            </div>
        </div>
        <!--End Search Form Drawer-->

        <!--Top Header-->
        <div class="top-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-auto text-center text-sm-left">
                        <p class="phone-no"><i class="anm anm-phone-s"></i> +440 0(111) 044 833</p>
                    </div>
                    <div class="col-12 col-sm-auto text-center text-sm-left mt-1 mt-sm-0 pl-sm-4">
                        <p class="top-header_middle-text">Швидка доставка по Україні</p>
                    </div>
                </div>
            </div>
        </div>
        <!--End Top Header-->

        <!--Header-->
        <div class="<?php echo esc_attr($header_wrap_classes); ?>">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <!--Desktop Logo-->
                    <div class="logo col-md-2 col-lg-2 d-none d-lg-block">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/logo.svg"
                                alt="DE Shop" title="DE Shop" />
                        </a>
                    </div>
                    <!--End Desktop Logo-->

                    <div class="col-2 col-sm-3 col-md-3 col-lg-8">
                        <div class="d-block d-lg-none">
                            <button type="button"
                                class="btn--link site-header__menu js-mobile-nav-toggle mobile-nav--open">
                                <i class="icon anm anm-times-l"></i>
                                <i class="anm anm-bars-r"></i>
                            </button>
                        </div>

                        <!--Desktop Menu-->
                        <nav class="grid__item" id="AccessibleNav">
                            <ul id="siteNav" class="<?php echo esc_attr($site_nav_classes); ?>">
                                <li class="lvl1<?php echo $is_home ? ' active' : ''; ?>">
                                    <a href="<?php echo esc_url(home_url('/')); ?>">Головна</a>
                                </li>
                                <li class="lvl1<?php echo $is_catalog ? ' active' : ''; ?>">
                                    <a href="<?php echo esc_url($catalog_url); ?>">Каталог</a>
                                </li>
                            </ul>
                        </nav>
                        <!--End Desktop Menu-->
                    </div>

                    <!--Mobile Logo-->
                    <div class="col-6 col-sm-6 col-md-6 col-lg-2 d-block d-lg-none mobile-logo">
                        <div class="logo">
                            <a href="<?php echo esc_url(home_url('/')); ?>">
                                <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/logo.svg"
                                    alt="DE Shop" title="DE Shop" />
                            </a>
                        </div>
                    </div>
                    <!--End Mobile Logo-->

                    <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                        <div class="site-cart">
                            <a href="<?php echo esc_url($order_url); ?>" class="site-header__cart" title="Замовлення"
                                data-order-url="<?php echo esc_url($order_url); ?>">
                                <i class="icon anm anm-bag-l"></i>
                                <span id="CartCount" class="site-header__cart-count"
                                    data-cart-render="item_count">0</span>
                            </a>
                        </div>
                        <div class="site-header__search">
                            <button type="button" class="search-trigger"><i class="icon anm anm-search-l"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Header-->

        <!--Mobile Menu-->
        <div class="mobile-nav-wrapper" role="navigation">
            <div class="closemobileMenu"><i class="icon anm anm-times-l pull-right"></i> Закрити меню</div>
            <ul id="MobileNav" class="mobile-nav">
                <li class="lvl1<?php echo $is_home ? ' active' : ''; ?>">
                    <a href="<?php echo esc_url(home_url('/')); ?>">Головна</a>
                </li>
                <li class="lvl1<?php echo $is_catalog ? ' active' : ''; ?>">
                    <a href="<?php echo esc_url($catalog_url); ?>">Каталог</a>
                </li>
            </ul>
        </div>
        <!--End Mobile Menu-->