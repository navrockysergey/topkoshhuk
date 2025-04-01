<?php
$args = array(
    'taxonomy'     => 'product_cat',
    'orderby'      => 'name',
    'order'        => 'ASC',
    'hide_empty'   => false,
    'exclude'      => array(15),
    'parent'       => 0,
);

$categories = get_terms($args);

if (!empty($categories)) : ?>
    <ul class="menu-categories">
        <?php foreach ($categories as $category) : 
            $category_link = get_term_link($category);
            $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
            $image_url = wp_get_attachment_url($thumbnail_id);
            $image_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
        ?>
            <li class="menu-category menu-category-<?php echo $category->term_id; ?>">
                <a href="<?php echo esc_url($category_link); ?>">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                    <?php endif; ?>
                    <span><?php echo esc_html($category->name); ?></span>
                </a>

                <?php 
                $args_subcategories = array(
                    'taxonomy'     => 'product_cat',
                    'child_of'     => $category->term_id,
                    'orderby'      => 'name',
                    'order'        => 'ASC',
                    'hide_empty'   => false,
                );
                $subcategories = get_terms($args_subcategories);

                if (!empty($subcategories)) : ?>
                    <ul class="menu-subcategories">
                        <?php foreach ($subcategories as $subcategory) : 
                            $subcategory_link = get_term_link($subcategory);
                            $subcategory_thumbnail_id = get_term_meta($subcategory->term_id, 'thumbnail_id', true);
                            $subcategory_image_url = wp_get_attachment_url($subcategory_thumbnail_id);
                            $subcategory_image_alt = get_post_meta($subcategory_thumbnail_id, '_wp_attachment_image_alt', true);
                        ?>
                            <li class="menu-subcategory">
                                <a href="<?php echo esc_url($subcategory_link); ?>">
                                    <?php if ($subcategory_image_url) : ?>
                                        <img src="<?php echo esc_url($subcategory_image_url); ?>" alt="<?php echo esc_attr($subcategory_image_alt); ?>">
                                    <?php endif; ?>
                                    <span><?php echo esc_html($subcategory->name); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
