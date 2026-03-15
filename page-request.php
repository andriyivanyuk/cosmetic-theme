<?php

if (!defined('ABSPATH')) {
    exit;
}

$catalog_url = function_exists('de_shop_get_catalog_url')
    ? de_shop_get_catalog_url()
    : home_url('/catalog/');

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
                <div class="alert alert-success text-uppercase" role="alert">
                    <i class="icon anm anm-truck-l icon-large"></i> &nbsp;
                    <strong><?php esc_html_e('Готово!', 'de-shop-theme'); ?></strong>
                    <?php esc_html_e('Ваші товари додані до замовлення.', 'de-shop-theme'); ?>
                </div>

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
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="customer_phone"><?php esc_html_e('Телефон', 'de-shop-theme'); ?></label>
                                    <input type="text" id="customer_phone" name="customer_phone" required>
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
                                                <?php esc_html_e('Нова Пошта (відділення)', 'de-shop-theme'); ?></option>
                                        <?php endif; ?>
                                    </select>
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
                                        </div>
                                        <div class="form-group col-md-12 col-lg-12 col-xl-12 required">
                                            <label
                                                for="delivery_city_ref"><?php esc_html_e('Оберіть місто', 'de-shop-theme'); ?></label>
                                            <select id="delivery_city_ref" name="delivery_city_ref">
                                                <option value="">
                                                    <?php esc_html_e(' --- Оберіть місто --- ', 'de-shop-theme'); ?>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 col-lg-12 col-xl-12 required">
                                            <label
                                                for="delivery_warehouse_ref"><?php esc_html_e('Оберіть відділення', 'de-shop-theme'); ?></label>
                                            <select id="delivery_warehouse_ref" name="delivery_warehouse_ref">
                                                <option value="">
                                                    <?php esc_html_e(' --- Оберіть відділення --- ', 'de-shop-theme'); ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label
                                        for="customer_comment"><?php esc_html_e('Коментар до замовлення', 'de-shop-theme'); ?></label>
                                    <textarea id="customer_comment" name="customer_comment" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-right col-12 col-sm-12 col-md-12 col-lg-12">
                                <button type="submit"
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
        var isNovaPoshtaEnabled = <?php echo $nova_poshta_enabled ? 'true' : 'false'; ?>;
        var deliveryMethodSelect = document.getElementById('delivery_method');
        var novaPoshtaFields = document.getElementById('nova-poshta-fields');
        var citySearchInput = document.getElementById('delivery_city_search');
        var citySelect = document.getElementById('delivery_city_ref');
        var warehouseSelect = document.getElementById('delivery_warehouse_ref');
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

        function toggleNovaPoshtaFields() {
            if (!deliveryMethodSelect || !novaPoshtaFields) {
                return;
            }

            var isNovaPoshta = deliveryMethodSelect.value === 'nova_poshta' && isNovaPoshtaEnabled;
            novaPoshtaFields.style.display = isNovaPoshta ? '' : 'none';

            if (citySelect) {
                citySelect.required = isNovaPoshta;
            }

            if (warehouseSelect) {
                warehouseSelect.required = isNovaPoshta;
            }

            if (!isNovaPoshta) {
                if (citySearchInput) {
                    citySearchInput.value = '';
                }

                setSelectOptions(citySelect, [], ' --- Оберіть місто --- ');
                setSelectOptions(warehouseSelect, [], ' --- Оберіть відділення --- ');
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
                    setSelectOptions(citySelect, [], ' --- Оберіть місто --- ');
                    setSelectOptions(warehouseSelect, [], ' --- Оберіть відділення --- ');
                    return;
                }

                citySearchDebounce = setTimeout(function () {
                    searchNovaPoshtaCities(query)
                        .then(function (data) {
                            var items = data && data.success && data.data && Array.isArray(data.data.items)
                                ? data.data.items
                                : [];

                            setSelectOptions(citySelect, items, ' --- Оберіть місто --- ');
                            setSelectOptions(warehouseSelect, [], ' --- Оберіть відділення --- ');
                        })
                        .catch(function () {
                            setSelectOptions(citySelect, [], ' --- Оберіть місто --- ');
                            setSelectOptions(warehouseSelect, [], ' --- Оберіть відділення --- ');
                        });
                }, 300);
            });
        }

        if (citySelect) {
            citySelect.addEventListener('change', function () {
                var cityRef = citySelect.value ? String(citySelect.value) : '';

                if (cityRef === '') {
                    setSelectOptions(warehouseSelect, [], ' --- Оберіть відділення --- ');
                    return;
                }

                loadNovaPoshtaWarehouses(cityRef)
                    .then(function (data) {
                        var items = data && data.success && data.data && Array.isArray(data.data.items)
                            ? data.data.items
                            : [];

                        setSelectOptions(warehouseSelect, items, ' --- Оберіть відділення --- ');
                    })
                    .catch(function () {
                        setSelectOptions(warehouseSelect, [], ' --- Оберіть відділення --- ');
                    });
            });
        }

        toggleNovaPoshtaFields();

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            var customerNameInput = document.getElementById('customer_name');
            var customerPhoneInput = document.getElementById('customer_phone');
            var customerCommentInput = document.getElementById('customer_comment');

            var customerName = customerNameInput ? customerNameInput.value.trim() : '';
            var customerPhone = customerPhoneInput ? customerPhoneInput.value.trim() : '';
            var customerComment = customerCommentInput ? customerCommentInput.value.trim() : '';
            var deliveryMethod = deliveryMethodSelect ? String(deliveryMethodSelect.value || 'pickup') : 'pickup';
            var deliveryCityRef = citySelect ? String(citySelect.value || '') : '';
            var deliveryWarehouseRef = warehouseSelect ? String(warehouseSelect.value || '') : '';
            var deliveryCityName = citySelect && citySelect.selectedIndex >= 0
                ? String(citySelect.options[citySelect.selectedIndex].text || '')
                : '';
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

            if (customerName === '') {
                if (messageEl) {
                    messageEl.textContent = 'Будь ласка, вкажіть ім\'я та прізвище.';
                }
                return;
            }

            if (customerPhone === '') {
                if (messageEl) {
                    messageEl.textContent = 'Будь ласка, вкажіть телефон.';
                }
                return;
            }

            if (deliveryMethod === 'nova_poshta') {
                if (!isNovaPoshtaEnabled) {
                    if (messageEl) {
                        messageEl.textContent = 'Доставка Новою Поштою тимчасово недоступна.';
                    }
                    return;
                }

                if (deliveryCityRef === '' || deliveryWarehouseRef === '') {
                    if (messageEl) {
                        messageEl.textContent = 'Оберіть місто та відділення Нової Пошти.';
                    }
                    return;
                }
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
                        if (messageEl) {
                            messageEl.textContent = 'Замовлення успішно оформлено.';
                        }
                        saveCart([]);
                        renderCart();
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

