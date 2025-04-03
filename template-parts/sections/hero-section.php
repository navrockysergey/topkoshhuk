<?php
    $main_top_heading_text  = ! empty( $main_top_heading_text ) ? esc_html( $main_top_heading_text ) : get_the_title();
?>
<section class="section section-main">
    <div class="container">

        <?php get_product_search_form(); ?>

        <?php if ( 'text' == $main_top_heading_type ) : ?>
            <h1 class="section-title">
                <?php echo $main_top_heading_text?>
            </h1>
        <?php endif; ?>

        <?php echo $inner_blocks ?>
        
        <div class="content">
            <?php
            if( ! empty( $main_bottom_text ) ) :
                ?>
                <div class="text">
                    <?php echo esc_html( $main_bottom_text )?>
                </div>

                <?php
            endif;

            if ( ! empty( $main_bottom_button_text ) ) :
                ?>
                <a href="<?php echo esc_url( $main_bottom_button_link )?>" class="button button-catalog">
                    <span><?php echo esc_html( $main_bottom_button_text )?></span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.8 11.6C17.0666 11.8 17.0666 12.2 16.8 12.4L9.8 17.8991C9.47038 18.1463 9 17.9111 9 17.4991L9 6.50091C9 6.08888 9.47038 5.85369 9.8 6.10091L16.8 11.6Z" fill="currentColor"></path>
                    </svg>
                </a>
                <?php
            endif;

            if ( ! empty( $main_bottom_second_text ) ) :
                ?>
                <div class="text">
                    <?php echo esc_html( $main_bottom_second_text )?>
                </div>
                <?php
            endif;
            ?>
        </div>
    </div>
</section>