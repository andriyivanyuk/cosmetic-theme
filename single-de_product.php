<?php

if (!defined('ABSPATH')) {
    exit;
}

$product_data_service = class_exists('\DE_Shop\Products\ProductData')
    ? new \DE_Shop\Products\ProductData()
    : null;

get_header();
?>

<div id="page-content">
    <div id="MainContent" class="main-content" role="main">
        <?php if (have_posts()): ?>
            <?php while (have_posts()):
                the_post(); ?>
                <?php
                $product_data = is_object($product_data_service)
                    ? $product_data_service->get_product_data(get_the_ID())
                    : [];

                $product_id = isset($product_data['id']) ? (int) $product_data['id'] : get_the_ID();
                $product_title = isset($product_data['title']) ? (string) $product_data['title'] : get_the_title();
                $product_permalink = get_permalink($product_id);

                $product_price = isset($product_data['price']) ? (string) $product_data['price'] : '';
                $product_old_price = isset($product_data['old_price']) ? (string) $product_data['old_price'] : '';
                $product_currency = isset($product_data['currency']) ? (string) $product_data['currency'] : '';

                $request_button_label = isset($product_data['request_button_label']) ? (string) $product_data['request_button_label'] : '';
                if ($request_button_label !== '') {
                    $request_button_label = str_ireplace(['запит', 'Запит'], ['замовлення', 'Замовлення'], $request_button_label);
                }

                $request_button_text = '' !== trim($request_button_label)
                    ? $request_button_label
                    : 'Додати до замовлення';

                $sku = class_exists('\\DE_Shop\\Products\\ProductMeta')
                    ? \DE_Shop\Products\ProductMeta::get_sku($product_id)
                    : '';

                $description = class_exists('\\DE_Shop\\Products\\ProductMeta')
                    ? \DE_Shop\Products\ProductMeta::get_description($product_id)
                    : '';

                $show_price = class_exists('\\DE_Shop\\Products\\ProductMeta')
                    ? \DE_Shop\Products\ProductMeta::should_show_price($product_id)
                    : true;

                $show_old_price = class_exists('\\DE_Shop\\Products\\ProductMeta')
                    ? \DE_Shop\Products\ProductMeta::should_show_old_price($product_id)
                    : false;

                $catalog_url = function_exists('de_shop_get_catalog_url')
                    ? de_shop_get_catalog_url()
                    : home_url('/catalog/');

                $order_url = function_exists('de_shop_get_order_url')
                    ? de_shop_get_order_url()
                    : home_url('/request/');

                $featured_image_url = isset($product_data['featured_image_url']) ? (string) $product_data['featured_image_url'] : '';
                $gallery_urls = isset($product_data['gallery_urls']) && is_array($product_data['gallery_urls'])
                    ? $product_data['gallery_urls']
                    : [];

                if ('' === $featured_image_url && !empty($gallery_urls)) {
                    $first_gallery_url = (string) reset($gallery_urls);
                    $featured_image_url = $first_gallery_url;
                }

                if ('' === $featured_image_url) {
                    $featured_image_url = get_stylesheet_directory_uri() . '/assets/images/product-detail-page/cape-dress-1.jpg';
                }

                $all_image_urls = [$featured_image_url];

                foreach ($gallery_urls as $gallery_url) {
                    if (!is_string($gallery_url) || '' === $gallery_url) {
                        continue;
                    }

                    $all_image_urls[] = $gallery_url;
                }

                $all_image_urls = array_values(array_unique($all_image_urls));

                $formatted_price = trim($product_price . ' ' . $product_currency);
                $formatted_old_price = trim($product_old_price . ' ' . $product_currency);
                ?>
                <div class="bredcrumbWrap">
                    <div class="container breadcrumbs">
                        <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Головна', 'de-shop-theme'); ?></a>
                        <span aria-hidden="true">›</span>
                        <a href="<?php echo esc_url($catalog_url); ?>"><?php esc_html_e('Каталог', 'de-shop-theme'); ?></a>
                        <span aria-hidden="true">›</span>
                        <span><?php echo esc_html($product_title); ?></span>
                    </div>
                </div>

                <div id="ProductSection-product-template" class="product-template__container prstyle2 container">
                    <div class="product-single product-single-1">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="product-details-img product-single__photos bottom">
                                    <div class="zoompro-wrap product-zoom-right pl-20">
                                        <div class="zoompro-span">
                                            <img class="blur-up lazyload zoompro"
                                                data-zoom-image="<?php echo esc_url($featured_image_url); ?>"
                                                src="<?php echo esc_url($featured_image_url); ?>"
                                                alt="<?php echo esc_attr($product_title); ?>" />
                                        </div>
                                        <div class="product-buttons">
                                            <a href="#" class="btn prlightbox" title="Zoom">
                                                <i class="icon anm anm-expand-l-arrows" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="product-thumb product-thumb-1">
                                        <div id="gallery" class="product-dec-slider-1 product-tab-left">
                                            <?php foreach ($all_image_urls as $image_url): ?>
                                                <a data-image="<?php echo esc_url($image_url); ?>"
                                                    data-zoom-image="<?php echo esc_url($image_url); ?>">
                                                    <img class="blur-up lazyload" src="<?php echo esc_url($image_url); ?>"
                                                        alt="<?php echo esc_attr($product_title); ?>" />
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="lightboximages" style="display:none;">
                                        <?php foreach ($all_image_urls as $image_url): ?>
                                            <?php
                                            $attachment_id = attachment_url_to_postid($image_url);
                                            $image_width = 1200;
                                            $image_height = 1200;

                                            if ($attachment_id > 0) {
                                                $metadata = wp_get_attachment_metadata($attachment_id);

                                                if (is_array($metadata)) {
                                                    $meta_width = isset($metadata['width']) ? (int) $metadata['width'] : 0;
                                                    $meta_height = isset($metadata['height']) ? (int) $metadata['height'] : 0;

                                                    if ($meta_width > 0 && $meta_height > 0) {
                                                        $image_width = $meta_width;
                                                        $image_height = $meta_height;
                                                    }
                                                }
                                            }
                                            ?>
                                            <a href="<?php echo esc_url($image_url); ?>"
                                                data-size="<?php echo esc_attr($image_width . 'x' . $image_height); ?>"></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="product-single__meta">
                                    <h1 class="product-single__title"><?php echo esc_html($product_title); ?></h1>

                                    <div class="prInfoRow">
                                        <div class="product-stock">
                                            <span class="instock"><?php esc_html_e('В наявності', 'de-shop-theme'); ?></span>
                                        </div>
                                        <div class="product-sku">SKU:
                                            <span class="variant-sku"><?php echo esc_html($sku !== '' ? $sku : '-'); ?></span>
                                        </div>
                                    </div>

                                    <p class="product-single__price product-single__price-product-template">
                                        <?php if ($show_old_price && '' !== $formatted_old_price): ?>
                                            <s><span class="money"><?php echo esc_html($formatted_old_price); ?></span></s>
                                        <?php endif; ?>

                                        <?php if ($show_price && '' !== $formatted_price): ?>
                                            <span
                                                class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
                                                <span class="money"><?php echo esc_html($formatted_price); ?></span>
                                            </span>
                                        <?php endif; ?>

                                        <?php if ((!$show_price || '' === $formatted_price) && (!$show_old_price || '' === $formatted_old_price)): ?>
                                            <span class="money"><?php esc_html_e('Ціну уточнюйте', 'de-shop-theme'); ?></span>
                                        <?php endif; ?>
                                    </p>

                                    <div class="product-action clearfix">
                                        <div class="product-form__item--quantity">
                                            <div class="wrapQtyBtn">
                                                <div class="qtyField">
                                                    <a class="qtyBtn minus" href="javascript:void(0);" aria-label="Зменшити">
                                                        <i class="fa anm anm-minus-r" aria-hidden="true"></i>
                                                    </a>
                                                    <input type="text" id="de-single-quantity" name="quantity" value="1"
                                                        class="product-form__input qty">
                                                    <a class="qtyBtn plus" href="javascript:void(0);" aria-label="Збільшити">
                                                        <i class="fa anm anm-plus-r" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-form__item--submit">
                                            <button type="button" id="add-to-request" class="btn product-form__cart-submit"
                                                data-product-id="<?php echo esc_attr((string) $product_id); ?>"
                                                data-product-title="<?php echo esc_attr($product_title); ?>"
                                                data-product-price="<?php echo esc_attr($formatted_price); ?>"
                                                data-product-image="<?php echo esc_url($featured_image_url); ?>">
                                                <span><?php echo esc_html($request_button_text); ?></span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="display-table shareRow">
                                        <div class="display-table-cell text-right" style="width:100%;">
                                            <div class="social-sharing">
                                                <a target="_blank" rel="noopener noreferrer"
                                                    href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode((string) $product_permalink); ?>"
                                                    class="btn btn--small btn--secondary btn--share share-facebook"
                                                    title="Facebook">
                                                    <i class="fa fa-facebook-square" aria-hidden="true"></i>
                                                    <span class="share-title" aria-hidden="true">Facebook</span>
                                                </a>
                                                <a target="_blank" rel="noopener noreferrer" href="https://www.instagram.com/"
                                                    class="btn btn--small btn--secondary btn--share" title="Instagram">
                                                    <i class="fa fa-instagram" aria-hidden="true"></i>
                                                    <span class="share-title" aria-hidden="true">Instagram</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <p>
                                        <a
                                            href="<?php echo esc_url($order_url); ?>"><?php esc_html_e('Перейти до замовлення', 'de-shop-theme'); ?></a>
                                    </p>
                                </div>

                                <?php if ('' !== trim($description)): ?>
                                    <div class="tabs-listing">
                                        <div class="tab-container">
                                            <h3 class="acor-ttl active"><?php esc_html_e('Опис товару', 'de-shop-theme'); ?></h3>
                                            <div class="tab-content" style="display:block;">
                                                <div class="product-description rte">
                                                    <?php echo wp_kses_post(wpautop($description)); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="container">
                <p><?php esc_html_e('Товар не знайдено.', 'de-shop-theme'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Закрити (Esc)"></button>
                <button class="pswp__button pswp__button--share" title="Поділитися"></button>
                <button class="pswp__button pswp__button--fs" title="Повноекранний режим"></button>
                <button class="pswp__button pswp__button--zoom" title="Збільшити/зменшити"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="Попереднє (стрілка вліво)"></button>
            <button class="pswp__button pswp__button--arrow--right" title="Наступне (стрілка вправо)"></button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var button = document.getElementById('add-to-request');
        var quantityInput = document.getElementById('de-single-quantity');

        if (!button) {
            return;
        }

        var normalizeQuantity = function (value) {
            var parsed = parseInt(value, 10);

            if (Number.isNaN(parsed) || parsed < 1) {
                return 1;
            }

            return parsed;
        };

        if (quantityInput) {
            quantityInput.addEventListener('change', function () {
                quantityInput.value = String(normalizeQuantity(quantityInput.value));
            });
        }

        button.addEventListener('click', function () {
            var productId = button.getAttribute('data-product-id');
            var productTitle = button.getAttribute('data-product-title');
            var productPrice = button.getAttribute('data-product-price');
            var productImage = button.getAttribute('data-product-image');
            var quantity = quantityInput ? normalizeQuantity(quantityInput.value) : 1;

            var cart = [];
            var saved = localStorage.getItem('de_cart');

            if (saved) {
                try {
                    cart = JSON.parse(saved) || [];
                } catch (e) {
                    cart = [];
                }
            }

            var existingItem = null;

            cart.forEach(function (item) {
                if (item && String(item.id) === String(productId)) {
                    existingItem = item;
                }
            });

            if (existingItem) {
                var currentQty = parseInt(existingItem.qty, 10);
                existingItem.qty = Number.isNaN(currentQty) ? quantity : currentQty + quantity;
            } else {
                cart.push({
                    id: productId,
                    title: productTitle,
                    price: productPrice,
                    image: productImage,
                    qty: quantity
                });
            }

            localStorage.setItem('de_cart', JSON.stringify(cart));
            window.dispatchEvent(new Event('de:cart-updated'));

            if (window.deShopCart && typeof window.deShopCart.showToast === 'function') {
                var safeTitle = productTitle ? String(productTitle) : 'Товар';
                var qtyText = quantity > 1 ? ' x' + String(quantity) : '';
                window.deShopCart.showToast('Додано до кошика: ' + safeTitle + qtyText);
            }
        });
    });
</script>

<?php
get_footer();

