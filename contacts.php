<?php
/* 
Template Name: Contact Us
*/

get_header();
$opening_hours = get_theme_mod('opening_hours');
$address = get_theme_mod('address');
$coordinates = get_theme_mod('coordinates');
$coordinates_array = explode(',', $coordinates);
$lat = isset($coordinates_array[0]) ? trim($coordinates_array[0]) : '';
$lng = isset($coordinates_array[1]) ? trim($coordinates_array[1]) : '';

?>
<div class="breadcrumb-container">
    <div class="container">
        <?php
            if ( function_exists('yoast_breadcrumb') ) {
                yoast_breadcrumb( '<div id="breadcrumbs">','</div>' );
            }
        ?>
    </div>
</div>

<div class="header-title">
    <div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</div>

<section class="section section-contacts">
    <div class="container">
        <div class="contacts-container">
            <div class="contacts-main">
                <div class="block">

                    <?php if (has_post_thumbnail()): ?>
                        <div class="image">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="info">
                        <?php if ($address) : ?>
                            <h3><?php _e('Склад'); ?></h3>
                            
                            <div class="footer-opening-hours">
                                <?php echo nl2br(esc_html($address)); ?>
                            </div>
                        <?php endif; ?>

                        <h3><?php _e('Телефони'); ?></h3>

                        <div class="phones">
                            <?php get_template_part( 'template-parts/blocks/block', 'phone' ); ?>
                        </div>

                        <?php if ($opening_hours) : ?>
                            <h3><?php _e('Працюємо'); ?></h3>
                            
                            <div class="footer-opening-hours">
                                <?php echo nl2br(esc_html($opening_hours)); ?>
                            </div>
                        <?php endif; ?>

                        <h3><?php _e('Ми онлайн'); ?></h3>
                        <?php get_template_part( 'template-parts/blocks/block', 'social-links' ); ?>
                    </div>
                </div>
            </div>
            <div class="map">
                <div class="map-wrapper">
                    <iframe 
                        width="100%" 
                        height="300" 
                        frameborder="0" 
                        style="border:0" 
                        src="https://www.google.com/maps?q=<?php echo esc_attr($lat); ?>,<?php echo esc_attr($lng); ?>&z=15&output=embed" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
            <div class="form">
                <?php echo do_shortcode( '[contact-form-7 id="61f1cd8"]' ); ?>
            </div>
        </div>

        <?php if (get_the_content()) : ?>
            <div class="content">
                <?php the_content(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer();
