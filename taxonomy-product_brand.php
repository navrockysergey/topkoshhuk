<?php 
get_header();  

$current_brand = null;
$current_category = null;
$current_sort = 'date';
$current_order = 'DESC';

if (is_tax('product_brand')) {
    $current_brand = get_queried_object();
}

$current_category = get_current_category_from_url();

if (isset($_GET['ordr'])) {
    $sort_param = $_GET['ordr'];
    switch ($sort_param) {
        case 'price':
            $current_sort = 'meta_value_num';
            $current_order = 'ASC';
            $meta_key = '_price';
            break;
        case 'price-desc':
            $current_sort = 'meta_value_num';
            $current_order = 'DESC';
            $meta_key = '_price';
            break;
        case 'sales_number':
            $current_sort = 'meta_value_num';
            $current_order = 'DESC';
            $meta_key = 'total_sales';
            break;
        default:
            $current_sort = 'date';
            $current_order = 'DESC';
            break;
    }
}
?>

<main id="primary" class="site-main">
    <section class="section section-category-hero">
        <div class="container">
            <?php get_template_part('template-parts/blocks/block', 'search'); ?>
            <?php get_template_part('template-parts/blocks/block', 'category'); ?>
        </div>
    </section>
    
    <div class="container category-container">
        <?php if (is_active_sidebar('category_container_before')) : ?>
            <div class="category-before">
                <?php dynamic_sidebar('category_container_before'); ?>
            </div>
        <?php endif; ?>

        <div class="category-side">
            <?php get_template_part('template-parts/blocks/block', 'filter'); ?>
        </div>

        <div class="category-main">

            <?php if ($current_brand): ?>
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 18,
                    'paged' => $paged,
                    'orderby' => $current_sort,
                    'order' => $current_order,
                    'meta_query' => array(
                        array(
                            'key' => '_stock_status',
                            'value' => 'instock',
                            'compare' => '='
                        )
                    )
                );

                if (isset($meta_key)) {
                    $args['meta_key'] = $meta_key;
                }

                $tax_query = array(
                    array(
                        'taxonomy' => 'product_brand',
                        'field'    => 'slug',
                        'terms'    => $current_brand->slug,
                    )
                );

                if ($current_category) {
                    $tax_query[] = array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => $current_category->slug,
                    );
                }

                $args['tax_query'] = array(
                    'relation' => 'AND',
                    $tax_query
                );

                $products_query = new WP_Query($args);

                if ($products_query->have_posts()) :
                    echo '<div class="woocommerce columns-3">';
                    woocommerce_product_loop_start();
                    
                    while ($products_query->have_posts()) : $products_query->the_post();
                        wc_get_template_part('content', 'product');
                    endwhile;
                    
                    woocommerce_product_loop_end();
                    echo '</div>';
                    
                    $pagination_base = $base_url . '%_%';
                    if (isset($_GET['ordr'])) {
                        $pagination_base = add_query_arg('ordr', $_GET['ordr'], $pagination_base);
                    }
                    
                    echo '<div class="woocommerce-pagination">';
                    echo paginate_links(array(
                        'total' => $products_query->max_num_pages,
                        'current' => $paged,
                        'format' => '?paged=%#%',
                        'add_args' => isset($_GET['ordr']) ? array('ordr' => $_GET['ordr']) : array(),
                    ));
                    echo '</div>';
                    
                    wp_reset_postdata();
                else :
                    if ($current_category) {
                        echo '<p>Товари цього бренду в категорії "' . $current_category->name . '" не знайдено.</p>';
                    } else {
                        echo '<p>Товари цього бренду не знайдено.</p>';
                    }
                endif;
                ?>
            <?php else: ?>
                <?php echo do_shortcode('[products limit="18" columns="3" orderby="date" order="DESC" paginate=true]'); ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>