<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();

$catalog_url = function_exists('de_shop_get_catalog_url')
    ? de_shop_get_catalog_url()
    : home_url('/de-products/');

$paged = max(1, (int) get_query_var('paged'));
$selected_category = isset($_GET['de_cat']) ? absint(wp_unslash((string) $_GET['de_cat'])) : 0;
$sort_by = isset($_GET['sort_by']) ? sanitize_key(wp_unslash((string) $_GET['sort_by'])) : 'manual';

$parse_price_param = static function (string $param_name): array {
    if (!isset($_GET[$param_name])) {
        return [null, false];
    }

    $raw = sanitize_text_field(wp_unslash((string) $_GET[$param_name]));
    $raw = trim(str_replace(',', '.', $raw));

    if ($raw === '' || !is_numeric($raw)) {
        return [null, false];
    }

    return [(float) $raw, true];
};

[$min_price, $has_min_filter] = $parse_price_param('min_price');
[$max_price, $has_max_filter] = $parse_price_param('max_price');

if ($min_price !== null && $min_price < 0) {
    $min_price = 0.0;
}

if ($max_price !== null && $max_price < 0) {
    $max_price = 0.0;
}

$query_args = [
    'post_type' => 'de_product',
    'post_status' => 'publish',
    'posts_per_page' => 12,
    'paged' => $paged,
];

if ($selected_category > 0) {
    $query_args['tax_query'] = [
        [
            'taxonomy' => 'de_product_category',
            'field' => 'term_id',
            'terms' => $selected_category,
        ],
    ];
}

$range_query_args = [
    'post_type' => 'de_product',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'fields' => 'ids',
    'no_found_rows' => true,
];

if ($selected_category > 0) {
    $range_query_args['tax_query'] = [
        [
            'taxonomy' => 'de_product_category',
            'field' => 'term_id',
            'terms' => $selected_category,
        ],
    ];
}

$range_query = new WP_Query($range_query_args);
$price_values = [];

foreach ((array) $range_query->posts as $range_product_id) {
    $raw_price = (string) get_post_meta((int) $range_product_id, 'de_price', true);
    $raw_price = trim(str_replace(',', '.', $raw_price));

    if ($raw_price === '' || !is_numeric($raw_price)) {
        continue;
    }

    $price_values[] = (float) $raw_price;
}

$price_min_bound = !empty($price_values) ? floor((float) min($price_values)) : 0.0;
$price_max_bound = !empty($price_values) ? ceil((float) max($price_values)) : 1000.0;

if ($price_max_bound <= $price_min_bound) {
    $price_max_bound = $price_min_bound + 1.0;
}

$active_min_price = $has_min_filter && $min_price !== null ? $min_price : $price_min_bound;
$active_max_price = $has_max_filter && $max_price !== null ? $max_price : $price_max_bound;

$active_min_price = max($price_min_bound, min($active_min_price, $price_max_bound));
$active_max_price = max($price_min_bound, min($active_max_price, $price_max_bound));

if ($active_min_price > $active_max_price) {
    $tmp = $active_min_price;
    $active_min_price = $active_max_price;
    $active_max_price = $tmp;
}

$meta_query = [];

if ($has_min_filter) {
    $meta_query[] = [
        'key' => 'de_price',
        'value' => $active_min_price,
        'compare' => '>=',
        'type' => 'NUMERIC',
    ];
}

if ($has_max_filter) {
    $meta_query[] = [
        'key' => 'de_price',
        'value' => $active_max_price,
        'compare' => '<=',
        'type' => 'NUMERIC',
    ];
}

if (!empty($meta_query)) {
    $query_args['meta_query'] = $meta_query;
}

switch ($sort_by) {
    case 'title-ascending':
        $query_args['orderby'] = 'title';
        $query_args['order'] = 'ASC';
        break;

    case 'title-descending':
        $query_args['orderby'] = 'title';
        $query_args['order'] = 'DESC';
        break;

    case 'price-ascending':
        $query_args['meta_key'] = 'de_price';
        $query_args['orderby'] = 'meta_value_num';
        $query_args['order'] = 'ASC';
        break;

    case 'price-descending':
        $query_args['meta_key'] = 'de_price';
        $query_args['orderby'] = 'meta_value_num';
        $query_args['order'] = 'DESC';
        break;

    case 'created-ascending':
        $query_args['orderby'] = 'date';
        $query_args['order'] = 'ASC';
        break;

    case 'best-selling':
    case 'created-descending':
    case 'manual':
    default:
        $query_args['orderby'] = 'date';
        $query_args['order'] = 'DESC';
        break;
}

$catalog_query = new WP_Query($query_args);
$theme_uri = get_stylesheet_directory_uri();
$order_url = function_exists('de_shop_get_order_url')
    ? de_shop_get_order_url()
    : home_url('/request/');

$top_categories = get_terms([
    'taxonomy' => 'de_product_category',
    'hide_empty' => false,
    'parent' => 0,
]);

$query_state = [
    'sort_by' => $sort_by,
    'min_price' => $has_min_filter ? (string) $active_min_price : '',
    'max_price' => $has_max_filter ? (string) $active_max_price : '',
];

$amount_value = '$' . (int) $active_min_price . ' - $' . (int) $active_max_price;

$all_categories_url = add_query_arg(array_filter($query_state, static fn($value): bool => $value !== ''), $catalog_url);
?>
<div id="page-content">
    <div class="collection-header">
        <div class="collection-hero">
            <div class="collection-hero__image">
                <img class="blur-up lazyload" data-src="<?php echo esc_url($theme_uri); ?>/assets/images/cat-women2.jpg"
                    src="<?php echo esc_url($theme_uri); ?>/assets/images/cat-women2.jpg" alt="Каталог"
                    title="Каталог" />
            </div>
            <div class="collection-hero__title-wrapper">
                <h1 class="collection-hero__title page-width">Каталог</h1>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-3 col-lg-2 sidebar filterbar">
                <div class="closeFilter d-block d-md-none d-lg-none"><i class="icon icon anm anm-times-l"></i></div>
                <div class="sidebar_tags">
                    <div class="sidebar_widget categories filter-widget">
                        <div class="widget-title">
                            <h2>Категорії</h2>
                        </div>
                        <div class="widget-content">
                            <ul class="sidebar_categories">
                                <li class="lvl-1<?php echo $selected_category === 0 ? ' active' : ''; ?>">
                                    <a href="<?php echo esc_url($all_categories_url); ?>" class="site-nav">Усі
                                        товари</a>
                                </li>
                                <?php if (!is_wp_error($top_categories) && !empty($top_categories)): ?>
                                    <?php foreach ($top_categories as $category): ?>
                                        <?php
                                        $children = get_terms([
                                            'taxonomy' => 'de_product_category',
                                            'hide_empty' => false,
                                            'parent' => (int) $category->term_id,
                                        ]);

                                        $category_url = add_query_arg(array_filter([
                                            'de_cat' => (int) $category->term_id,
                                            'sort_by' => $sort_by,
                                            'min_price' => $query_state['min_price'],
                                            'max_price' => $query_state['max_price'],
                                        ], static fn($value): bool => $value !== ''), $catalog_url);

                                        $is_active = $selected_category === (int) $category->term_id;
                                        ?>
                                        <li
                                            class="<?php echo !empty($children) ? 'level1 sub-level' : 'lvl-1'; ?><?php echo $is_active ? ' active' : ''; ?>">
                                            <a href="<?php echo esc_url($category_url); ?>"
                                                class="site-nav"><?php echo esc_html($category->name); ?></a>
                                            <?php if (!empty($children) && !is_wp_error($children)): ?>
                                                <ul class="sublinks">
                                                    <?php foreach ($children as $child): ?>
                                                        <?php
                                                        $child_url = add_query_arg(array_filter([
                                                            'de_cat' => (int) $child->term_id,
                                                            'sort_by' => $sort_by,
                                                            'min_price' => $query_state['min_price'],
                                                            'max_price' => $query_state['max_price'],
                                                        ], static fn($value): bool => $value !== ''), $catalog_url);
                                                        ?>
                                                        <li
                                                            class="level2<?php echo $selected_category === (int) $child->term_id ? ' active' : ''; ?>">
                                                            <a href="<?php echo esc_url($child_url); ?>"
                                                                class="site-nav"><?php echo esc_html($child->name); ?></a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="sidebar_widget filterBox filter-widget">
                        <div class="widget-title">
                            <h2>Ціна</h2>
                        </div>
                        <form action="<?php echo esc_url($catalog_url); ?>" method="get" class="price-filter"
                            id="de-price-filter-form">
                            <?php if ($selected_category > 0): ?>
                                <input type="hidden" name="de_cat"
                                    value="<?php echo esc_attr((string) $selected_category); ?>">
                            <?php endif; ?>
                            <input type="hidden" name="sort_by" value="<?php echo esc_attr($sort_by); ?>">
                            <input type="hidden" name="min_price" id="de-min-price"
                                value="<?php echo esc_attr($query_state['min_price']); ?>">
                            <input type="hidden" name="max_price" id="de-max-price"
                                value="<?php echo esc_attr($query_state['max_price']); ?>">

                            <div id="slider-range" data-min="<?php echo esc_attr((string) $price_min_bound); ?>"
                                data-max="<?php echo esc_attr((string) $price_max_bound); ?>"
                                data-current-min="<?php echo esc_attr((string) $active_min_price); ?>"
                                data-current-max="<?php echo esc_attr((string) $active_max_price); ?>"></div>
                            <div class="row">
                                <div class="col-6">
                                    <p class="no-margin">
                                        <input id="amount" type="text" value="<?php echo esc_attr($amount_value); ?>"
                                            readonly>
                                    </p>
                                </div>
                                <div class="col-6 text-right margin-25px-top">
                                    <button class="btn btn-secondary btn--small">Фільтр</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-9 col-lg-10 main-col">
                <div class="productList">
                    <button type="button" class="btn btn-filter d-block d-md-none d-lg-none">Фільтри товарів</button>

                    <div class="toolbar">
                        <div class="filters-toolbar-wrapper">
                            <div class="row">
                                <div
                                    class="col-4 col-md-4 col-lg-4 filters-toolbar__item collection-view-as d-flex justify-content-start align-items-center">
                                    <a href="#" title="Сітка" class="change-view change-view--active" data-view="grid"
                                        aria-label="Сітка">
                                        <img src="<?php echo esc_url($theme_uri); ?>/assets/images/grid.jpg"
                                            alt="Сітка" />
                                    </a>
                                    <a href="#" title="Список" class="change-view" data-view="list" aria-label="Список">
                                        <img src="<?php echo esc_url($theme_uri); ?>/assets/images/list.jpg"
                                            alt="Список" />
                                    </a>
                                </div>
                                <div
                                    class="col-4 col-md-4 col-lg-4 text-center filters-toolbar__item filters-toolbar__item--count d-flex justify-content-center align-items-center">
                                    <span class="filters-toolbar__product-count">Показано:
                                        <?php echo (int) $catalog_query->found_posts; ?></span>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4 text-right">
                                    <form action="<?php echo esc_url($catalog_url); ?>" method="get"
                                        class="filters-toolbar__item" id="de-sort-form">
                                        <?php if ($selected_category > 0): ?>
                                            <input type="hidden" name="de_cat"
                                                value="<?php echo esc_attr((string) $selected_category); ?>">
                                        <?php endif; ?>
                                        <?php if ($query_state['min_price'] !== ''): ?>
                                            <input type="hidden" name="min_price"
                                                value="<?php echo esc_attr($query_state['min_price']); ?>">
                                        <?php endif; ?>
                                        <?php if ($query_state['max_price'] !== ''): ?>
                                            <input type="hidden" name="max_price"
                                                value="<?php echo esc_attr($query_state['max_price']); ?>">
                                        <?php endif; ?>
                                        <label for="SortBy" class="hidden">Сортування</label>
                                        <select name="sort_by" id="SortBy"
                                            class="filters-toolbar__input filters-toolbar__input--sort">
                                            <option value="manual" <?php selected($sort_by, 'manual'); ?>>Сортувати
                                            </option>
                                            <option value="best-selling" <?php selected($sort_by, 'best-selling'); ?>>
                                                Популярні</option>
                                            <option value="title-ascending" <?php selected($sort_by, 'title-ascending'); ?>>За алфавітом, А-Я</option>
                                            <option value="title-descending" <?php selected($sort_by, 'title-descending'); ?>>За алфавітом, Я-А</option>
                                            <option value="price-ascending" <?php selected($sort_by, 'price-ascending'); ?>>Ціна, від низької до високої</option>
                                            <option value="price-descending" <?php selected($sort_by, 'price-descending'); ?>>Ціна, від високої до низької</option>
                                            <option value="created-descending" <?php selected($sort_by, 'created-descending'); ?>>Спочатку нові</option>
                                            <option value="created-ascending" <?php selected($sort_by, 'created-ascending'); ?>>Спочатку старі</option>
                                        </select>
                                        <input class="collection-header__default-sort" type="hidden" value="manual">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid-products grid--view-items" id="de-catalog-products" data-default-view="grid">
                        <div class="row">
                            <?php if ($catalog_query->have_posts()): ?>
                                <?php while ($catalog_query->have_posts()):
                                    $catalog_query->the_post(); ?>
                                    <?php
                                    $product_id = get_the_ID();
                                    $price = (string) get_post_meta($product_id, 'de_price', true);
                                    $old_price = (string) get_post_meta($product_id, 'de_old_price', true);
                                    $currency = (string) get_post_meta($product_id, 'de_currency', true);
                                    $sku = (string) get_post_meta($product_id, 'de_sku', true);
                                    $description = (string) get_post_meta($product_id, 'de_description', true);

                                    $show_price = '1' === (string) get_post_meta($product_id, 'de_show_price', true);
                                    $show_old_price = '1' === (string) get_post_meta($product_id, 'de_show_old_price', true);

                                    $formatted_price = trim($price . ' ' . $currency);
                                    $formatted_old_price = trim($old_price . ' ' . $currency);
                                    $formatted_price = $formatted_price !== '' ? $formatted_price : 'Ціну уточнюйте';
                                    $thumb = has_post_thumbnail()
                                        ? get_the_post_thumbnail_url($product_id, 'large')
                                        : '';

                                    if (!is_string($thumb) || $thumb === '') {
                                        $gallery_value = get_post_meta($product_id, 'de_gallery_ids', true);
                                        $gallery_ids = [];

                                        if (is_array($gallery_value)) {
                                            $gallery_ids = $gallery_value;
                                        } elseif (is_string($gallery_value) && $gallery_value !== '') {
                                            $gallery_ids = explode(',', $gallery_value);
                                        }

                                        foreach ($gallery_ids as $gallery_id_raw) {
                                            $gallery_id = absint((string) $gallery_id_raw);

                                            if ($gallery_id < 1) {
                                                continue;
                                            }

                                            $gallery_thumb = wp_get_attachment_image_url($gallery_id, 'large');

                                            if (is_string($gallery_thumb) && $gallery_thumb !== '') {
                                                $thumb = $gallery_thumb;
                                                break;
                                            }
                                        }
                                    }

                                    if (!is_string($thumb) || $thumb === '') {
                                        $thumb = $theme_uri . '/assets/images/product-images/product-image1.jpg';
                                    }
                                    ?>
                                    <?php
                                    $list_description_source = $description !== ''
                                        ? $description
                                        : (string) get_the_excerpt();
                                    $list_description = wp_trim_words(
                                        wp_strip_all_tags($list_description_source),
                                        28,
                                        '...'
                                    );
                                    ?>
                                    <div class="col-6 col-sm-6 col-md-4 col-lg-3 grid-view-item style2 item de-catalog-item">
                                        <div class="grid-view_image">
                                            <a href="<?php the_permalink(); ?>" class="grid-view-item__link">
                                                <img class="grid-view-item__image primary blur-up lazyload"
                                                    data-src="<?php echo esc_url($thumb); ?>"
                                                    src="<?php echo esc_url($thumb); ?>"
                                                    alt="<?php the_title_attribute(); ?>" />
                                                <img class="grid-view-item__image hover blur-up lazyload"
                                                    data-src="<?php echo esc_url($thumb); ?>"
                                                    src="<?php echo esc_url($thumb); ?>"
                                                    alt="<?php the_title_attribute(); ?>" />
                                            </a>
                                            <div class="product-details hoverDetails text-center">
                                                <div class="product-name">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </div>
                                                <div class="product-price">
                                                    <?php if ($show_old_price && $formatted_old_price !== ''): ?>
                                                        <span class="old-price"><?php echo esc_html($formatted_old_price); ?></span>
                                                    <?php endif; ?>
                                                    <?php if ($show_price): ?>
                                                        <span class="price"><?php echo esc_html($formatted_price); ?></span>
                                                    <?php endif; ?>
                                                    <?php if (!$show_price && !$show_old_price): ?>
                                                        <span class="price">Ціну уточнюйте</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="button-set">
                                                    <a href="javascript:void(0)" title="Швидкий перегляд"
                                                        class="quick-view-popup quick-view js-open-quickview"
                                                        data-toggle="modal" data-target="#content_quickview"
                                                        data-product-id="<?php echo esc_attr((string) $product_id); ?>"
                                                        data-product-title="<?php echo esc_attr(get_the_title()); ?>"
                                                        data-product-sku="<?php echo esc_attr($sku); ?>"
                                                        data-product-image="<?php echo esc_url($thumb); ?>"
                                                        data-product-price="<?php echo esc_attr($formatted_price); ?>">
                                                        <i class="icon anm anm-search-plus-r"></i>
                                                    </a>
                                                    <form action="<?php echo esc_url($order_url); ?>" method="get">
                                                        <button
                                                            class="btn btn--secondary cartIcon btn-addto-cart js-add-to-request"
                                                            type="button"
                                                            data-product-id="<?php echo esc_attr((string) $product_id); ?>"
                                                            data-product-title="<?php echo esc_attr(get_the_title()); ?>"
                                                            data-product-price="<?php echo esc_attr($formatted_price); ?>"
                                                            data-product-image="<?php echo esc_url($thumb); ?>"
                                                            title="Додати до замовлення" aria-label="Додати до замовлення">
                                                            <i class="icon anm anm-bag-l"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="de-list-view-content">
                                            <div class="product-name de-list-view-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </div>

                                            <div class="de-list-view-description">
                                                <?php echo esc_html($list_description); ?>
                                            </div>

                                            <div class="product-price de-list-view-price">
                                                <?php if ($show_old_price && $formatted_old_price !== ''): ?>
                                                    <span class="old-price"><?php echo esc_html($formatted_old_price); ?></span>
                                                <?php endif; ?>
                                                <?php if ($show_price): ?>
                                                    <span class="price"><?php echo esc_html($formatted_price); ?></span>
                                                <?php endif; ?>
                                                <?php if (!$show_price && !$show_old_price): ?>
                                                    <span class="price">Ціну уточнюйте</span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="de-list-view-actions">
                                                <button class="btn btn--small js-add-to-request" type="button"
                                                    data-product-id="<?php echo esc_attr((string) $product_id); ?>"
                                                    data-product-title="<?php echo esc_attr(get_the_title()); ?>"
                                                    data-product-price="<?php echo esc_attr($formatted_price); ?>"
                                                    data-product-image="<?php echo esc_url($thumb); ?>"
                                                    title="Додати до замовлення" aria-label="Додати до замовлення">Додати до
                                                    замовлення</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="col-12">
                                    <p>У каталозі поки немає товарів.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if ($catalog_query->max_num_pages > 1): ?>
                    <div class="infinitpaginOuter">
                        <div class="infinitpagin text-center">
                            <?php
                            echo paginate_links([
                                'total' => $catalog_query->max_num_pages,
                                'current' => $paged,
                                'mid_size' => 1,
                                'prev_text' => '«',
                                'next_text' => '»',
                                'add_args' => array_filter([
                                    'de_cat' => $selected_category,
                                    'sort_by' => $sort_by,
                                    'min_price' => $query_state['min_price'],
                                    'max_price' => $query_state['max_price'],
                                ], static fn($value): bool => $value !== ''),
                            ]);
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
wp_reset_postdata();
get_footer();
