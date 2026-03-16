<?php

if (!defined('ABSPATH')) {
    exit;
}

$catalog_url = function_exists('de_shop_get_catalog_url')
    ? de_shop_get_catalog_url()
    : home_url('/catalog/');

$thank_you_url = function_exists('de_shop_get_thank_you_url')
    ? de_shop_get_thank_you_url()
    : home_url('/thank-you/');

$nova_poshta_enabled = class_exists('\\DE_Shop\\Requests\\DeliverySettings')
    ? \DE_Shop\Requests\DeliverySettings::is_nova_poshta_enabled()
    : false;

get_header();
?>

<div id="page-content">
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width"><?php esc_html_e('Замовлення', 'de-shop-theme'); ?></h1>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">
                <form id="de-order-table-form" action="#" method="post" class="cart style2">
                    <table>
                        <thead class="cart__row cart__header">
                            <tr>
                                <th colspan="2" class="text-center"><?php esc_html_e('Товар', 'de-shop-theme'); ?></th>
                                <th class="text-center"><?php esc_html_e('Ціна', 'de-shop-theme'); ?></th>
                                <th class="text-center"><?php esc_html_e('Кількість', 'de-shop-theme'); ?></th>
                                <th class="text-right"><?php esc_html_e('Сума', 'de-shop-theme'); ?></th>
                                <th class="action">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody id="order-cart-body"></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-left">
                                    <a href="<?php echo esc_url($catalog_url); ?>"
                                        class="btn btn-secondary btn--small cart-continue">
                                        <?php esc_html_e('Продовжити покупки', 'de-shop-theme'); ?>
                                    </a>
                                </td>
                                <td colspan="3" class="text-right">
                                    <button type="button" id="de-clear-order"
                                        class="btn btn-secondary btn--small small--hide">
                                        <?php esc_html_e('Очистити', 'de-shop-theme'); ?>
                                    </button>
                                    <button type="button" id="de-refresh-order"
                                        class="btn btn-secondary btn--small cart-continue ml-2">
                                        <?php esc_html_e('Оновити', 'de-shop-theme'); ?>
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>

                <div class="order-summary-inline mb-4">
                    <div class="order-summary-inline__item">
                        <span><?php esc_html_e('Позицій', 'de-shop-theme'); ?></span>
                        <strong id="order-summary-lines">0</strong>
                    </div>
                    <div class="order-summary-inline__item">
                        <span><?php esc_html_e('Одиниць товару', 'de-shop-theme'); ?></span>
                        <strong id="order-summary-qty">0</strong>
                    </div>
                    <div class="order-summary-inline__item order-summary-inline__item--total">
                        <span><?php esc_html_e('Загальна сума', 'de-shop-theme'); ?></span>
                        <strong id="order-summary-total">0 UAH</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">
                <div class="mb-4">
                    <form method="post" action="#" id="order-checkout-form" class="contact-form">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label
                                        for="customer_name"><?php esc_html_e('Ім\'я та прізвище', 'de-shop-theme'); ?></label>
                                    <input type="text" id="customer_name" name="customer_name" required>
                                    <small
                                        class="de-field-help"><?php esc_html_e('Вкажіть повне ім\'я отримувача.', 'de-shop-theme'); ?></small>
                                    <small class="de-field-error"
                                        data-error-for="customer_name"><?php esc_html_e('Поле є обов\'язковим.', 'de-shop-theme'); ?></small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="customer_phone"><?php esc_html_e('Телефон', 'de-shop-theme'); ?></label>
                                    <input type="text" id="customer_phone" name="customer_phone" required>
                                    <small
                                        class="de-field-help"><?php esc_html_e('Формат: +380XXXXXXXXX або 0XXXXXXXXX.', 'de-shop-theme'); ?></small>
                                    <small class="de-field-error"
                                        data-error-for="customer_phone"><?php esc_html_e('Поле є обов\'язковим.', 'de-shop-theme'); ?></small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label
                                        for="delivery_method"><?php esc_html_e('Спосіб доставки', 'de-shop-theme'); ?></label>
                                    <select id="delivery_method" name="delivery_method" required>
                                        <option value="pickup"><?php esc_html_e('Самовивіз', 'de-shop-theme'); ?>
                                        </option>
                                        <?php if ($nova_poshta_enabled): ?>
                                            <option value="nova_poshta">
                                                <?php esc_html_e('Нова Пошта (відділення)', 'de-shop-theme'); ?>
                                            </option>
                                        <?php endif; ?>
                                    </select>
                                    <small
                                        class="de-field-help"><?php esc_html_e('Оберіть потрібний спосіб отримання товару.', 'de-shop-theme'); ?></small>
                                    <small class="de-field-error"
                                        data-error-for="delivery_method"><?php esc_html_e('Оберіть спосіб доставки.', 'de-shop-theme'); ?></small>
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12" id="nova-poshta-fields"
                                style="display:none;">
                                <fieldset>
                                    <div class="row">
                                        <div class="form-group col-md-12 col-lg-12 col-xl-12 required">
                                            <label
                                                for="delivery_city_search"><?php esc_html_e('Місто (Нова Пошта)', 'de-shop-theme'); ?></label>
                                            <input type="text" id="delivery_city_search"
                                                placeholder="<?php esc_attr_e('Почніть вводити назву міста', 'de-shop-theme'); ?>"
                                                autocomplete="off">
                                            <input type="hidden" id="delivery_city_ref" name="delivery_city_ref"
                                                value="">
                                            <input type="hidden" id="delivery_city_name" name="delivery_city_name"
                                                value="">
                                            <div id="delivery_city_results" class="de-city-search-results"
                                                style="display:none;"></div>
                                            <small
                                                class="de-field-help"><?php esc_html_e('Введіть мінімум 2 символи і оберіть місто зі списку.', 'de-shop-theme'); ?></small>
                                            <small class="de-field-error"
                                                data-error-for="delivery_city_search"><?php esc_html_e('Оберіть місто зі списку.', 'de-shop-theme'); ?></small>
                                        </div>
                                        <div class="form-group col-md-12 col-lg-12 col-xl-12 required">
                                            <label
                                                for="delivery_warehouse_ref"><?php esc_html_e('Оберіть відділення', 'de-shop-theme'); ?></label>
                                            <select id="delivery_warehouse_ref" name="delivery_warehouse_ref">
                                                <option value="">
                                                    <?php esc_html_e(' --- Оберіть відділення --- ', 'de-shop-theme'); ?>
                                                </option>
                                            </select>
                                            <small
                                                class="de-field-help"><?php esc_html_e('Після вибору міста оберіть потрібне відділення.', 'de-shop-theme'); ?></small>
                                            <small class="de-field-error"
                                                data-error-for="delivery_warehouse_ref"><?php esc_html_e('Оберіть відділення.', 'de-shop-theme'); ?></small>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label
                                        for="customer_comment"><?php esc_html_e('Коментар до замовлення', 'de-shop-theme'); ?></label>
                                    <textarea id="customer_comment" name="customer_comment" rows="5"></textarea>
                                    <small
                                        class="de-field-help"><?php esc_html_e('Необов\'язково: уточнення по часу чи доставці.', 'de-shop-theme'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-right col-12 col-sm-12 col-md-12 col-lg-12">
                                <button type="submit" id="order-submit-btn"
                                    class="btn mb-3"><?php esc_html_e('Оформити замовлення', 'de-shop-theme'); ?></button>
                            </div>
                        </div>
                    </form>
                    <p id="order-submit-message"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #nova-poshta-fields .form-group {
        position: relative;
    }

    .de-city-search-results {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        border: 1px solid #d8d8d8;
        background: #fff;
        max-height: 260px;
        overflow-y: auto;
        z-index: 30;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
    }

    .de-city-search-results__list {
        display: flex;
        flex-direction: column;
    }

    .de-city-search-results__item {
        width: 100%;
        border: 0;
        border-bottom: 1px solid #f1f1f1;
        background: #fff;
        text-align: left;
        padding: 10px 12px;
        font-size: 14px;
        line-height: 1.35;
        cursor: pointer;
        transition: background-color 0.15s ease;
    }

    .de-city-search-results__item:last-child {
        border-bottom: 0;
    }

    .de-city-search-results__item:hover,
    .de-city-search-results__item:focus {
        background: #f5f5f5;
        outline: none;
    }

    .de-field-help {
        display: block;
        margin-top: 6px;
        color: #7a7a7a;
        font-size: 12px;
        line-height: 1.35;
    }

    .de-field-error {
        display: none;
        margin-top: 6px;
        color: #d63638;
        font-size: 12px;
        line-height: 1.35;
    }

    .de-field-error.is-visible {
        display: block;
    }

    .de-invalid-input {
        border-color: #d63638 !important;
    }

    #order-submit-btn[disabled] {
        opacity: 0.55;
        filter: saturate(0.65);
        cursor: not-allowed;
        box-shadow: inset 0 0 0 999px rgba(255, 255, 255, 0.12);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tbody = document.getElementById('order-cart-body');
        var form = document.getElementById('order-checkout-form');
        var messageEl = document.getElementById('order-submit-message');
        var clearButton = document.getElementById('de-clear-order');
        var refreshButton = document.getElementById('de-refresh-order');
        var summaryLinesEl = document.getElementById('order-summary-lines');
        var summaryQtyEl = document.getElementById('order-summary-qty');
        var summaryTotalEl = document.getElementById('order-summary-total');
        var ajaxUrl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
        var nonce = '<?php echo esc_js(wp_create_nonce('de_submit_request')); ?>';
        var fallbackImage = '<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/product-images/product-image1.jpg'); ?>';
        var thankYouUrl = '<?php echo esc_url($thank_you_url); ?>';
        var isNovaPoshtaEnabled = <?php echo $nova_poshta_enabled ? 'true' : 'false'; ?>;
        var deliveryMethodSelect = document.getElementById('delivery_method');
        var novaPoshtaFields = document.getElementById('nova-poshta-fields');
        var citySearchInput = document.getElementById('delivery_city_search');
        var cityRefInput = document.getElementById('delivery_city_ref');
        var cityNameInput = document.getElementById('delivery_city_name');
        var cityResults = document.getElementById('delivery_city_results');
        var warehouseSelect = document.getElementById('delivery_warehouse_ref');
        var submitButton = document.getElementById('order-submit-btn');
        var citySearchDebounce = null;

        if (!tbody) {
            return;
        }

        function loadCart() {
            var items = [];
            var rawCart = localStorage.getItem('de_cart');

            if (!rawCart) {
                return items;
            }

            try {
                var parsed = JSON.parse(rawCart);
                if (Array.isArray(parsed)) {
                    items = parsed;
                }
            } catch (e) {
                items = [];
            }

            return items;
        }

        function saveCart(items) {
            localStorage.setItem('de_cart', JSON.stringify(items));
            window.dispatchEvent(new Event('de:cart-updated'));
        }

        function parsePrice(rawPrice) {
            var value = String(rawPrice || '').replace(',', '.');
            var numberMatch = value.match(/-?\d+(?:\.\d+)?/);
            var amount = numberMatch ? parseFloat(numberMatch[0]) : NaN;
            var currency = value.replace(/[-\d\s.,]/g, '').trim();

            if (currency === '') {
                currency = 'UAH';
            }

            return {
                amount: Number.isNaN(amount) ? null : amount,
                currency: currency,
                raw: value.trim()
            };
        }

        function formatLineTotal(priceText, qty) {
            var parsed = parsePrice(priceText);

            if (parsed.amount === null) {
                return parsed.raw !== '' ? parsed.raw : 'Ціну уточнюйте';
            }

            var total = parsed.amount * qty;
            var rounded = Number.isInteger(total) ? String(total) : total.toFixed(2);

            return rounded + ' ' + parsed.currency;
        }

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function formatAmount(value) {
            var rounded = Math.round(value * 100) / 100;

            if (Number.isInteger(rounded)) {
                return String(rounded);
            }

            return rounded.toFixed(2);
        }

        function renderSummary(items) {
            var lines = 0;
            var totalQty = 0;
            var totalAmount = 0;
            var currency = 'UAH';

            items.forEach(function (item) {
                if (!item || typeof item !== 'object') {
                    return;
                }

                lines += 1;

                var qty = item && item.qty ? parseInt(item.qty, 10) : 1;
                if (Number.isNaN(qty) || qty < 1) {
                    qty = 1;
                }

                totalQty += qty;

                var parsed = parsePrice(item.price || '');

                if (parsed.currency !== '') {
                    currency = parsed.currency;
                }

                if (parsed.amount !== null) {
                    totalAmount += parsed.amount * qty;
                }
            });

            if (summaryLinesEl) {
                summaryLinesEl.textContent = String(lines);
            }

            if (summaryQtyEl) {
                summaryQtyEl.textContent = String(totalQty);
            }

            if (summaryTotalEl) {
                summaryTotalEl.textContent = formatAmount(totalAmount) + ' ' + currency;
            }
        }

        function renderCart() {
            var items = loadCart();

            tbody.innerHTML = '';
            renderSummary(items);

            if (!items.length) {
                tbody.innerHTML = '<tr class="cart__row border-bottom line1 cart-flex border-top"><td colspan="6" class="text-center">Ваше замовлення порожнє</td></tr>';
                return;
            }

            items.forEach(function (item) {
                var id = item && item.id ? String(item.id) : '';
                var title = item && item.title ? String(item.title) : '';
                var price = item && item.price ? String(item.price) : '';
                var image = item && item.image ? String(item.image) : fallbackImage;
                var qty = item && item.qty ? parseInt(item.qty, 10) : 1;

                if (Number.isNaN(qty) || qty < 1) {
                    qty = 1;
                }

                var rowHtml = '' +
                    '<tr class="cart__row border-bottom line1 cart-flex border-top" data-product-id="' + escapeHtml(id) + '">' +
                    '<td class="cart__image-wrapper cart-flex-item">' +
                    '<img class="cart__image" src="' + escapeHtml(image) + '" alt="' + escapeHtml(title) + '">' +
                    '</td>' +
                    '<td class="cart__meta small--text-left cart-flex-item">' +
                    '<div class="list-view-item__title">' + escapeHtml(title) + '</div>' +
                    '</td>' +
                    '<td class="cart__price-wrapper cart-flex-item"><span class="money">' + escapeHtml(price) + '</span></td>' +
                    '<td class="cart__update-wrapper cart-flex-item text-right">' +
                    '<div class="cart__qty text-center">' +
                    '<div class="qtyField">' +
                    '<a class="qtyBtn minus" href="javascript:void(0);" data-action="minus"><i class="icon icon-minus"></i></a>' +
                    '<input class="cart__qty-input qty" type="text" value="' + qty + '" pattern="[0-9]*">' +
                    '<a class="qtyBtn plus" href="javascript:void(0);" data-action="plus"><i class="icon icon-plus"></i></a>' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td class="text-right small--hide cart-price"><div><span class="money">' + escapeHtml(formatLineTotal(price, qty)) + '</span></div></td>' +
                    '<td class="text-center small--hide"><a href="#" class="btn btn--secondary cart__remove" data-action="remove" title="Видалити"><i class="icon anm anm-times-l"></i></a></td>' +
                    '</tr>';

                tbody.insertAdjacentHTML('beforeend', rowHtml);
            });
        }

        function updateItemQty(productId, delta) {
            var items = loadCart();

            items.forEach(function (item) {
                if (String(item && item.id ? item.id : '') === productId) {
                    var currentQty = parseInt(item.qty, 10);
                    var safeQty = Number.isNaN(currentQty) || currentQty < 1 ? 1 : currentQty;
                    var nextQty = safeQty + delta;

                    item.qty = nextQty < 1 ? 1 : nextQty;
                }
            });

            saveCart(items);
            renderCart();
        }

        function setItemQty(productId, rawQty) {
            var parsedQty = parseInt(String(rawQty || ''), 10);
            var nextQty = Number.isNaN(parsedQty) || parsedQty < 1 ? 1 : parsedQty;
            var items = loadCart();

            items.forEach(function (item) {
                if (String(item && item.id ? item.id : '') === productId) {
                    item.qty = nextQty;
                }
            });

            saveCart(items);
            renderCart();
        }

        function removeItem(productId) {
            var items = loadCart().filter(function (item) {
                return String(item && item.id ? item.id : '') !== productId;
            });

            saveCart(items);
            renderCart();
        }

        tbody.addEventListener('click', function (event) {
            var target = event.target;
            var button = target && target.closest ? target.closest('[data-action]') : null;

            if (!button) {
                return;
            }

            event.preventDefault();

            var row = button.closest('tr[data-product-id]');
            var productId = row ? String(row.getAttribute('data-product-id') || '') : '';

            if (productId === '') {
                return;
            }

            var action = String(button.getAttribute('data-action') || '');

            if (action === 'plus') {
                updateItemQty(productId, 1);
            } else if (action === 'minus') {
                updateItemQty(productId, -1);
            } else if (action === 'remove') {
                removeItem(productId);
            }
        });

        tbody.addEventListener('change', function (event) {
            var input = event.target;

            if (!input || !input.classList || !input.classList.contains('cart__qty-input')) {
                return;
            }

            var row = input.closest('tr[data-product-id]');
            var productId = row ? String(row.getAttribute('data-product-id') || '') : '';

            if (productId === '') {
                return;
            }

            setItemQty(productId, input.value);
        });

        if (clearButton) {
            clearButton.addEventListener('click', function () {
                saveCart([]);
                renderCart();
            });
        }

        if (refreshButton) {
            refreshButton.addEventListener('click', function () {
                renderCart();
            });
        }

        renderCart();

        if (!form) {
            return;
        }

        function setSelectOptions(selectElement, items, defaultLabel) {
            if (!selectElement) {
                return;
            }

            var html = '<option value="">' + escapeHtml(defaultLabel) + '</option>';

            items.forEach(function (item) {
                if (!item || typeof item !== 'object') {
                    return;
                }

                var ref = item.ref ? String(item.ref) : '';
                var name = item.name ? String(item.name) : '';

                if (ref === '' || name === '') {
                    return;
                }

                html += '<option value="' + escapeHtml(ref) + '">' + escapeHtml(name) + '</option>';
            });

            selectElement.innerHTML = html;
        }

        function getFieldErrorElement(fieldName) {
            return form ? form.querySelector('[data-error-for="' + fieldName + '"]') : null;
        }

        function showFieldError(fieldName, message, inputElement) {
            var errorEl = getFieldErrorElement(fieldName);

            if (errorEl) {
                if (message) {
                    errorEl.textContent = message;
                }
                errorEl.classList.add('is-visible');
            }

            if (inputElement) {
                inputElement.classList.add('de-invalid-input');
            }
        }

        function clearFieldError(fieldName, inputElement) {
            var errorEl = getFieldErrorElement(fieldName);

            if (errorEl) {
                errorEl.classList.remove('is-visible');
            }

            if (inputElement) {
                inputElement.classList.remove('de-invalid-input');
            }
        }

        function validateCheckoutForm(showErrors) {
            var valid = true;

            var customerNameInput = document.getElementById('customer_name');
            var customerPhoneInput = document.getElementById('customer_phone');

            var customerName = customerNameInput ? String(customerNameInput.value || '').trim() : '';
            var customerPhone = customerPhoneInput ? String(customerPhoneInput.value || '').trim() : '';
            var deliveryMethod = deliveryMethodSelect ? String(deliveryMethodSelect.value || '') : '';

            if (customerName === '') {
                valid = false;
                if (showErrors) {
                    showFieldError('customer_name', 'Поле є обов\'язковим.', customerNameInput);
                }
            } else {
                clearFieldError('customer_name', customerNameInput);
            }

            if (customerPhone === '') {
                valid = false;
                if (showErrors) {
                    showFieldError('customer_phone', 'Поле є обов\'язковим.', customerPhoneInput);
                }
            } else {
                clearFieldError('customer_phone', customerPhoneInput);
            }

            if (deliveryMethod === '') {
                valid = false;
                if (showErrors) {
                    showFieldError('delivery_method', 'Оберіть спосіб доставки.', deliveryMethodSelect);
                }
            } else {
                clearFieldError('delivery_method', deliveryMethodSelect);
            }

            var isNovaPoshta = deliveryMethod === 'nova_poshta' && isNovaPoshtaEnabled;
            var cityRef = cityRefInput ? String(cityRefInput.value || '').trim() : '';
            var warehouseRef = warehouseSelect ? String(warehouseSelect.value || '').trim() : '';

            if (isNovaPoshta) {
                if (cityRef === '') {
                    valid = false;
                    if (showErrors) {
                        showFieldError('delivery_city_search', 'Оберіть місто зі списку.', citySearchInput);
                    }
                } else {
                    clearFieldError('delivery_city_search', citySearchInput);
                }

                if (warehouseRef === '') {
                    valid = false;
                    if (showErrors) {
                        showFieldError('delivery_warehouse_ref', 'Оберіть відділення.', warehouseSelect);
                    }
                } else {
                    clearFieldError('delivery_warehouse_ref', warehouseSelect);
                }
            } else {
                clearFieldError('delivery_city_search', citySearchInput);
                clearFieldError('delivery_warehouse_ref', warehouseSelect);
            }

            if (submitButton) {
                submitButton.disabled = !valid;
            }

            return valid;
        }

        function renderCityResults(items) {
            if (!cityResults) {
                return;
            }

            if (!Array.isArray(items) || items.length === 0) {
                cityResults.innerHTML = '';
                cityResults.style.display = 'none';
                return;
            }

            var html = '<div class="de-city-search-results__list">';

            items.forEach(function (item) {
                if (!item || typeof item !== 'object') {
                    return;
                }

                var ref = item.ref ? String(item.ref) : '';
                var name = item.name ? String(item.name) : '';

                if (ref === '' || name === '') {
                    return;
                }

                html += '' +
                    '<button type="button" class="de-city-search-results__item" data-ref="' + escapeHtml(ref) + '" data-name="' + escapeHtml(name) + '">' +
                    escapeHtml(name) +
                    '</button>';
            });

            html += '</div>';

            cityResults.innerHTML = html;
            cityResults.style.display = 'block';
        }

        function resetCitySelection(clearInput) {
            if (cityRefInput) {
                cityRefInput.value = '';
            }

            if (cityNameInput) {
                cityNameInput.value = '';
            }

            if (clearInput && citySearchInput) {
                citySearchInput.value = '';
            }

            if (cityResults) {
                cityResults.innerHTML = '';
                cityResults.style.display = 'none';
            }

            setSelectOptions(warehouseSelect, [], ' --- Оберіть відділення --- ');
            validateCheckoutForm(false);
        }

        function applyCitySelection(ref, name) {
            if (cityRefInput) {
                cityRefInput.value = ref;
            }

            if (cityNameInput) {
                cityNameInput.value = name;
            }

            if (citySearchInput) {
                citySearchInput.value = name;
            }

            if (cityResults) {
                cityResults.style.display = 'none';
            }

            loadNovaPoshtaWarehouses(ref)
                .then(function (data) {
                    var items = data && data.success && data.data && Array.isArray(data.data.items)
                        ? data.data.items
                        : [];

                    setSelectOptions(warehouseSelect, items, ' --- Оберіть відділення --- ');
                    validateCheckoutForm(false);
                })
                .catch(function () {
                    setSelectOptions(warehouseSelect, [], ' --- Оберіть відділення --- ');
                    validateCheckoutForm(false);
                });
        }

        function toggleNovaPoshtaFields() {
            if (!deliveryMethodSelect || !novaPoshtaFields) {
                return;
            }

            var isNovaPoshta = deliveryMethodSelect.value === 'nova_poshta' && isNovaPoshtaEnabled;
            novaPoshtaFields.style.display = isNovaPoshta ? '' : 'none';

            if (citySearchInput) {
                citySearchInput.required = isNovaPoshta;
            }

            if (warehouseSelect) {
                warehouseSelect.required = isNovaPoshta;
            }

            if (!isNovaPoshta) {
                resetCitySelection(true);
            }
        }

        function searchNovaPoshtaCities(query) {
            var body = new URLSearchParams();
            body.append('action', 'de_np_search_cities');
            body.append('nonce', nonce);
            body.append('query', query);

            return fetch(ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: body.toString()
            }).then(function (response) {
                return response.json();
            });
        }

        function loadNovaPoshtaWarehouses(cityRef) {
            var body = new URLSearchParams();
            body.append('action', 'de_np_get_warehouses');
            body.append('nonce', nonce);
            body.append('city_ref', cityRef);

            return fetch(ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: body.toString()
            }).then(function (response) {
                return response.json();
            });
        }

        if (deliveryMethodSelect) {
            deliveryMethodSelect.addEventListener('change', function () {
                toggleNovaPoshtaFields();
                validateCheckoutForm(false);
            });
        }

        if (citySearchInput) {
            citySearchInput.addEventListener('input', function () {
                if (!deliveryMethodSelect || deliveryMethodSelect.value !== 'nova_poshta') {
                    return;
                }

   var query = citySearchInput.value.trim();

                if (citySearchDebounce) {
                    clearTimeout(citySearchDebounce);
                }

                if (query.length < 2) {
                    resetCitySelection(false);
                    return;
                }

                if (cityRefInput) {
                    cityRefInput.value = '';
                }

                if (cityNameInput) {
                    cityNameInput.value = '';
                }

                setSelectOptions(warehouseSelect, [], ' --- Оберіть відділення --- ');
                validateCheckoutForm(false);

                citySearchDebounce = setTimeout(function () {
                    searchNovaPoshtaCities(query)
                        .then(function (data) {
                            var items = data && data.success && data.data && Array.isArray(data.data.items)
                                ? data.data.items
                                : [];

                            renderCityResults(items);
                        })
                        .catch(function () {
                            resetCitySelection(false);
                        });
                }, 300);
            });

            citySearchInput.addEventListener('focus', function () {
                var query = citySearchInput.value.trim();

                if (query.length < 2 || !deliveryMethodSelect || deliveryMethodSelect.value !== 'nova_poshta') {
                    return;
                }

                if (cityResults && cityResults.innerHTML.trim() !== '') {
                    cityResults.style.display = 'block';
                }
            });

            citySearchInput.addEventListener('blur', function () {
                window.setTimeout(function () {
                    if (cityResults) {
                        cityResults.style.display = 'none';
                    }
                }, 150);
                validateCheckoutForm(true);
            });
        }

        if (warehouseSelect) {
            warehouseSelect.addEventListener('change', function () {
                validateCheckoutForm(true);
            });
        }

        var liveValidationInputs = [
            document.getElementById('customer_name'),
            document.getElementById('customer_phone')
        ];

        liveValidationInputs.forEach(function (inputEl) {
            if (!inputEl) {
                return;
            }

            inputEl.addEventListener('input', function () {
                validateCheckoutForm(false);
            });

            inputEl.addEventListener('blur', function () {
                validateCheckoutForm(true);
            });
        });

        if (cityResults) {
            cityResults.addEventListener('mousedown', function (event) {
                var target = event.target;
                var item = target && target.closest ? target.closest('.de-city-search-results__item') : null;

                if (!item) {
                    return;
                }

                event.preventDefault();

                var ref = String(item.getAttribute('data-ref') || '');
                var name = String(item.getAttribute('data-name') || '');

                if (ref === '' || name === '') {
                    return;
                }

                applyCitySelection(ref, name);
            });
        }

        toggleNovaPoshtaFields();
        validateCheckoutForm(false);

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            var customerNameInput = document.getElementById('customer_name');
            var customerPhoneInput = document.getElementById('customer_phone');
            var customerCommentInput = document.getElementById('customer_comment');

            var customerName = customerNameInput ? customerNameInput.value.trim() : '';
            var customerPhone = customerPhoneInput ? customerPhoneInput.value.trim() : '';
            var customerComment = customerCommentInput ? customerCommentInput.value.trim() : '';
            var deliveryMethod = deliveryMethodSelect ? String(deliveryMethodSelect.value || 'pickup') : 'pickup';
            var deliveryCityRef = cityRefInput ? String(cityRefInput.value || '') : '';
            var deliveryWarehouseRef = warehouseSelect ? String(warehouseSelect.value || '') : '';
            var deliveryCityName = cityNameInput ? String(cityNameInput.value || '') : '';
            var deliveryWarehouseName = warehouseSelect && warehouseSelect.selectedIndex >= 0
                ? String(warehouseSelect.options[warehouseSelect.selectedIndex].text || '')
                : '';
            var cartItems = loadCart();

            if (!cartItems.length) {
                if (messageEl) {
                    messageEl.textContent = 'Додайте хоча б один товар у замовлення.';
                }
                return;
            }

            if (!validateCheckoutForm(true)) {
                if (messageEl) {
                    messageEl.textContent = 'Заповніть обов\'язкові поля форми.';
                }
                return;
            }

            var body = new URLSearchParams();
            body.append('action', 'de_submit_request');
            body.append('nonce', nonce);
            body.append('customer_name', customerName);
            body.append('customer_phone', customerPhone);
            body.append('customer_comment', customerComment);
            body.append('delivery_method', deliveryMethod);
            body.append('delivery_city_ref', deliveryCityRef);
            body.append('delivery_city_name', deliveryCityName);
            body.append('delivery_warehouse_ref', deliveryWarehouseRef);
            body.append('delivery_warehouse_name', deliveryWarehouseName);
            body.append('cart_items', JSON.stringify(cartItems));

            fetch(ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: body.toString()
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    if (data && data.success) {
                        form.reset();
                        resetCitySelection(true);
                        toggleNovaPoshtaFields();
                        validateCheckoutForm(false);

                        if (messageEl) {
                            messageEl.textContent = 'Замовлення успішно оформлено.';
                        }

                        saveCart([]);
                        renderCart();

                        window.setTimeout(function () {
                            window.location.href = thankYouUrl;
                        }, 150);

                        return;
                    }

                    if (messageEl) {
                        messageEl.textContent = data && data.data && data.data.message
                            ? String(data.data.message)
                            : 'Не вдалося оформити замовлення.';
                    }
                })
                .catch(function () {
                    if (messageEl) {
                        messageEl.textContent = 'Не вдалося оформити замовлення.';
                    }
                });
        });
    });
</script>

<?php
get_footer();

