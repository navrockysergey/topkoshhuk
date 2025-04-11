<?php
get_header();

$vid = get_the_ID();

$departments        = wp_get_post_terms( $vid, 'department' );
$location           = carbon_get_post_meta( $vid, 'vacancie_localization' );
$workplace          = carbon_get_post_meta( $vid, 'vacancie_workplace' );
$work_days_count    = carbon_get_post_meta( $vid, 'vacancie_work_days_count' );
$negotiated_salary  = carbon_get_post_meta( $vid, 'negotiated_salary' );
$min_salary         = carbon_get_post_meta( $vid, 'min_salary' );
$max_salary         = carbon_get_post_meta( $vid, 'max_salary' );
$currency_symbol    = get_woocommerce_currency_symbol();
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
        <h2><?php echo get_the_title(209); ?></h2>
    </div>
</div>

<section class="section section-single-vacancie">
    <div class="container">

        <?php
        if ( $departments ) :
            ?>
            <div class="vacancie-header"><?php echo esc_html( $departments[0]->name )?></div>
            <?php
        endif;
        ?>

        <div class="vacancie-content">
            <h1><?php echo get_the_title()?></h1>
            <div class="vacancie-info">
                <?php
                if ( ! empty( $location ) ) :
                ?>
                <div class="datail-item">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 7.34694C3 7.15533 3.15533 7 3.34694 7C3.48067 7 3.60199 7.07711 3.66253 7.19635C3.95632 7.77503 4.32139 8.34363 4.69653 8.86609C5.5498 10.0544 6.51526 11.0867 6.99243 11.575C7.25867 11.8489 7.62354 12 8 12C8.37598 12 8.74023 11.8494 9.00635 11.5762C9.48267 11.0885 10.4492 10.0554 11.3035 8.86584C11.48 8.62003 11.6543 8.36399 11.82 8.10148C12.2315 7.44957 12.9251 7 13.696 7H16L7 18H5C3.89543 18 3 17.1046 3 16V7.34694Z" fill="#020202"/>
                        <path d="M9.5 18H19C20.1046 18 21 17.1046 21 16V15H12L9.5 18Z" fill="#020202"/>
                        <path d="M21 13V9C21 7.89543 20.1046 7 19 7H18.5L13.5 13H21Z" fill="#020202"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.17151 1.12927C5.92175 0.40625 6.93933 0 8.00012 0C9.06091 0 10.0784 0.40625 10.8285 1.12927C11.5786 1.85254 12 2.83337 12 3.85596C12 5.90906 9.21301 8.93323 8.29089 9.87756C8.21521 9.95569 8.10986 10 8 10C7.89014 10 7.78479 9.95569 7.70911 9.87756C6.78699 8.93408 4 5.90881 4 3.85596C4 2.83325 4.42139 1.85242 5.17151 1.12927ZM8 6C9.10461 6 10 5.10461 10 4C10 2.89539 9.10461 2 8 2C6.89539 2 6 2.89539 6 4C6 5.10461 6.89539 6 8 6Z" fill="#020202"/>
                    </svg>

                    <?php echo esc_html( $location )?>
                </div>
                <?php
                endif;

                if ( ! empty( $workplace ) ) :
                ?>
                <div class="datail-item">
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.667 5.5C11.667 5.22386 11.8908 5 12.167 5H13.167C13.4431 5 13.667 5.22386 13.667 5.5V11.2676C14.2648 11.6134 14.667 12.2597 14.667 13C14.667 13.1792 14.6434 13.3528 14.5992 13.518L18.5205 17.4393C18.7158 17.6346 18.7158 17.9512 18.5205 18.1464L17.8134 18.8536C17.6182 19.0488 17.3016 19.0488 17.1063 18.8536L13.185 14.9323C13.0198 14.9764 12.8462 15 12.667 15C11.5624 15 10.667 14.1046 10.667 13C10.667 12.2597 11.0692 11.6134 11.667 11.2676V5.5Z" fill="#020202"/>
                    </svg>

                    <?php echo esc_html( $workplace ) . ','?>

                    <?php
                    if ( ! empty( $work_days_count ) ) :
                        ?>
                            <?php
                                echo $work_days_count;
                                echo '/';
                                echo 7 - intval( $work_days_count );
                            ?>
                        <?php
                    endif;
                    ?>
                </div>
                <?php
                endif;
                ?>

                <div class="datail-item">
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.263 4.24001C11.003 5.55655 7.49242 6.64573 4.36508 8.24965C3.74963 8.59067 3.33301 9.2468 3.33301 10.0002V18.0002C3.33301 19.1048 4.22844 20.0002 5.33301 20.0002H19.333C20.4376 20.0002 21.333 19.1048 21.333 18.0002V10.0002C21.333 8.89567 20.4376 8.00024 19.333 8.00024L18.5627 6.07432C17.8842 4.37817 15.9569 3.55594 14.263 4.24001ZM19.333 11.0002C19.333 10.448 18.8853 10.0002 18.333 10.0002H6.33301C5.78072 10.0002 5.33301 10.448 5.33301 11.0002V17.0002C5.33301 17.5525 5.78072 18.0002 6.33301 18.0002H18.333C18.8853 18.0002 19.333 17.5525 19.333 17.0002H17.333C16.2284 17.0002 15.333 16.1048 15.333 15.0002V13.0002C15.333 11.8957 16.2284 11.0002 17.333 11.0002H19.333ZM19.333 13.0002V15.0002H17.833C17.5569 15.0002 17.333 14.7764 17.333 14.5002V13.5002C17.333 13.2241 17.5569 13.0002 17.833 13.0002H19.333Z" fill="#020202"/>
                    </svg>

                    <?php
                    if ( ! empty( $negotiated_salary ) && 'yes' == $negotiated_salary ) :
                        echo __( 'Договірна' );
                        else :
                            if ( ! empty ( $min_salary ) ) :
                                echo $min_salary;
                            endif;
                            
                            if ( ! empty ( $max_salary ) ) :
                                echo ' - ';
                                echo $max_salary;
                            endif;

                            echo ' ' . $currency_symbol;
                    endif;
                    ?>
                </div>
            </div>
        </div>

        <?php if (get_the_content()) : ?>
            <div class="content">
                <?php the_content(); ?>
            </div>
        <?php endif; ?>

        <h3><?php _e('Готові приєднатися до нас?'); ?></h3>

        <?php echo do_shortcode('[contact-form-7 id="3934835" title="Резюме"]'); ?>
    </div>
</section>

<?php
get_footer();
