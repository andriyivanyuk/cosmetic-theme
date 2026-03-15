<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<!--Body Content-->
<div id="page-content">
    <!--Головна slider-->
    <div class="slideshow slideshow-wrapper pb-section">
        <div class="home-slideshow">
            <div class="slide slideshow--medium">
                <div class="blur-up lazyload">
                    <img class="blur-up lazyload"
                        data-src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/slideshow-banners/home5-banner1.jpg"
                        src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/slideshow-banners/home5-banner1.jpg"
                        alt="The One" title="The One" />
                    <div class="slideshow__text-wrap slideshow__overlay classic middle">
                        <div class="slideshow__text-content classic left">
                            <div class="container">
                                <div class="wrap-caption left">
                                    <h2 class="h1 mega-title slideshow__title">The One</h2>
                                    <span class="mega-subtitle slideshow__subtitle">Complete your daring new
                                        look<br>with the one</span>
                                    <span class="btn">Магазин now</span>
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
                                    <span class="btn">Магазин now</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Головна slider-->

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
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Додати до
                                                    кошика</button>
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
                                                        class="lbl pr-label2">Хіт</span></div>
                                                <!-- End product label -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Додати до
                                                    кошика</button>
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
                                                <div class="product-labels"><span class="lbl on-sale">Розпродаж</span>
                                                </div>
                                                <!-- End product label -->
                                            </a>
                                            <!-- end product image -->

                                            <!-- Start product button -->
                                            <form class="variants add" action="#"
                                                onclick="window.location.href='cart.html'" method="post">
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Додати до
                                                    кошика</button>
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
                                                <div class="product-labels"><span class="lbl on-sale">Розпродаж</span>
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
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Додати до
                                                    кошика</button>
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
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Додати до
                                                    кошика</button>
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
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Додати до
                                                    кошика</button>
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
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Додати до
                                                    кошика</button>
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
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Додати до
                                                    кошика</button>
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
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Додати до
                                                    кошика</button>
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
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Додати до
                                                    кошика</button>
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
                                                <button class="btn btn-addto-cart" type="button" tabindex="0">Додати до
                                                    кошика</button>
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
                    <h3 class="h4"><a href="#">Кольорова косметика</a></h3>
                    <div class="rte-setting">
                        <p><strong>There is nothing more you can ask for. </strong>Gives your skin a natural glow with
                            matte finish</p>
                    </div>
                    <a href="#" class="btn no-border">Магазин Now</a>
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
                    <h3 class="h4"><a href="#">Колір для губ</a></h3>
                    <div class="rte-setting">
                        <p>Enjoy the stay. Love the Shine Logn Lasting Ultramatte perfact lip color</p>
                    </div>
                    <a href="#" class="btn no-border">Магазин Нове Arrivals</a>
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
                    <h3 class="h4"><a href="#">Підводка для очей</a></h3>
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

    <!--Товар Single-->
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
                            <!-- Товар Action -->
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
                                        <span>Додати в кошик</span>
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
                            <!-- End Товар Action -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Товар Single-->

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
<?php
get_footer();


