<?php
if (!defined('ABSPATH')) {
    exit;
}

$is_catalog = is_page('catalog') || is_page_template('page-catalog.php') || is_post_type_archive('de_product');
$home_url = home_url('/');
$catalog_url = function_exists('de_shop_get_catalog_url')
    ? de_shop_get_catalog_url()
    : home_url('/catalog/');
?>
<!--Footer-->
<footer id="footer">
    <?php if ($is_catalog): ?>
        <div class="newsletter-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-7 w-100 d-flex justify-content-start align-items-center">
                        <div class="section-header text-center text-lg-left">
                            <label class="h2">Ми в соц.мережах</label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-5 d-flex justify-content-end align-items-center">
                        <div class="footer-social">
                            <ul class="list--inline site-footer__social-icons social-icons">
                                <li><a class="social-icons__link" href="#" target="_blank" title="Facebook"><i
                                            class="icon icon-facebook"></i></a></li>
                                <li><a class="social-icons__link" href="#" target="_blank" title="Instagram"><i
                                            class="icon icon-instagram"></i><span
                                            class="icon__fallback-text">Instagram</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="site-footer">
        <div class="container">
            <div class="footer-top footer-top-compact">
                <div class="footer-compact-row">
                    <div class="footer-compact-col footer-nav-block">
                        <h4 class="h4">Інформація</h4>
                        <ul class="footer-inline-links">
                            <li><a href="<?php echo esc_url($home_url); ?>">Головна</a></li>
                            <li><a href="<?php echo esc_url($catalog_url); ?>">Каталог</a></li>
                        </ul>
                    </div>
                    <div class="footer-compact-col contact-box footer-contact-block">
                        <h4 class="h4">Зв'яжіться з нами</h4>
                        <ul class="addressFooter footer-inline-contact">
                            <li><i class="icon anm anm-map-marker-al"></i>
                                <p>55 Gallaxy Enque,<br>2568 steet, 23568 NY</p>
                            </li>
                            <li class="phone"><i class="icon anm anm-phone-s"></i>
                                <p>(440) 000 000 0000</p>
                            </li>
                            <li class="email"><i class="icon anm anm-envelope-l"></i>
                                <p>sales@yousite.com</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>

            <div class="footer-bottom">
                <div class="row">
                    <div class="col-12 text-center copyright">
                        <span>&copy; <?php echo esc_html(date_i18n('Y')); ?> DE Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--End Footer-->

<!--Scoll Top-->
<span id="site-scroll"><i class="icon anm anm-angle-up-r"></i></span>
<!--End Scoll Top-->

<!--Quick View popup-->
<div class="modal fade quick-view-popup" id="content_quickview">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div id="ProductSection-product-template" class="product-template__container prstyle1">
                    <div class="product-single">
                        <a href="javascript:void(0)" data-dismiss="modal" class="model-close-btn pull-right"
                            title="Закрити">
                            <span class="icon icon anm anm-times-l"></span>
                        </a>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="product-details-img">
                                    <div class="pl-20">
                                        <img id="de-quickview-image"
                                            src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/product-detail-page/camelia-reversible-big1.jpg"
                                            alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="product-single__meta">
                                    <h2 id="de-quickview-title" class="product-single__title">Швидкий перегляд товару
                                    </h2>
                                    <div class="prInfoRow">
                                        <div class="product-stock"><span class="instock">В наявності</span><span
                                                class="outstock hide">Недоступно</span></div>
                                        <div class="product-sku">SKU: <span id="de-quickview-sku"
                                                class="variant-sku">-</span></div>
                                    </div>
                                    <div class="product-action clearfix">
                                        <div class="product-form__item--submit">
                                            <button type="button" name="add"
                                                class="btn product-form__cart-submit js-quickview-add-to-request"
                                                data-product-id="" data-product-title="" data-product-price="">
                                                <span>Додати до замовлення</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Quick View popup-->

<?php wp_footer(); ?>
</div>
</body>

</html>