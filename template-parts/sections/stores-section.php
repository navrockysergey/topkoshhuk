<?php
$stores = apply_filters( 'get_stores', false );

if ( ! $stores->have_posts() ) {
    return;
}

?>

<section class="section section-stores">
    <div class="container">
        <div class="stores-container">
            <div class="items" id="stores">
                <?php
                    $first_item = true;
                    while ( $stores->have_posts() ) :
                        $stores->the_post();

                        $ID = get_the_ID();
                        $title                 = get_the_title();
                        $thumbnail             = get_the_post_thumbnail_url( $ID );
                        $latitude              = carbon_get_post_meta( $ID, 'branch_geo_latitude' );
                        $longitude             = carbon_get_post_meta( $ID, 'branch_geo_longitude' );
                        $addres_string         = carbon_get_post_meta( $ID, 'branch_addres_string' );
                        $shedule_before_string = carbon_get_post_meta( $ID, 'branch_shedule_before_string' );
                        $time_work_start       = carbon_get_post_meta( $ID, 'branch_time_work_start' );
                        $time_work_end         = carbon_get_post_meta( $ID, 'branch_time_work_end' );
                        $phones                = carbon_get_post_meta( $ID, 'branch_phones' );
                    ?>
                    <div class="item<?php echo $first_item ? ' active' : ''; ?>" data-lat="<?php echo esc_attr( $latitude )?>" data-lng="<?php echo esc_attr( $longitude )?>">

                        <?php if( !empty($thumbnail) ) : ?>
                            <div class="image">
                                <img src="<?php echo esc_url( $thumbnail )?>" alt="<?php echo $title?>">
                            </div>
                            <?php else: ?>
                            <div class="image image-logo">
                                <?php get_template_part( 'template-parts/blocks/block', 'logo' ); ?>
                            </div>
                        <?php endif; ?>

                        <h3><?php echo $title;?></h3>
                            
                        <?php
                        if ( ! empty( $addres_string ) ) :
                            ?>
                            <address>
                                <?php echo esc_html( $addres_string )?>
                            </address>
                            <?php
                        endif;
                        ?>

                        <?php
                        if ( ! empty( $time_work_start ) && ! empty( $time_work_end ) ) :
                        ?>
                        <div class="work-shedule">
                            <?php
                            if (!empty($shedule_before_string)) {
                                echo $shedule_before_string . ', ';
                            }
                            
                            if (is_numeric($time_work_start)) {
                                $formatted_start = sprintf('%02d:00', (int)$time_work_start);
                            } else {
                                $formatted_start = $time_work_start;
                            }
                            
                            if (is_numeric($time_work_end)) {
                                $formatted_end = sprintf('%02d:00', (int)$time_work_end);
                            } else {
                                $formatted_end = $time_work_end;
                            }
                            
                            echo $formatted_start . ' - ' . $formatted_end;
                            ?>
                        </div>
                        <?php
                        endif;

                        if( ! empty( $phones ) ) :
                        ?>
                        <div class="phones">
                            <?php
                            foreach( $phones as $phone ) :
                                $sanitise_phone = preg_replace('/\D/', '', $phone['contact_number'] );
                            ?>
                            <a href="tel:<?php echo $sanitise_phone ?>"><?php echo esc_html( $phone['contact_number'] )?></a>
                            <?php
                            endforeach;
                            ?>
                        </div>
                        <?php
                        endif;
                        ?>
                        
                        <div class="button button-map">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 7.34694C3 7.15533 3.15533 7 3.34694 7C3.48067 7 3.60199 7.07711 3.66253 7.19635C3.95632 7.77503 4.32139 8.34363 4.69653 8.86609C5.5498 10.0544 6.51526 11.0867 6.99243 11.575C7.25867 11.8489 7.62354 12 8 12C8.37598 12 8.74023 11.8494 9.00635 11.5762C9.48267 11.0885 10.4492 10.0554 11.3035 8.86584C11.48 8.62003 11.6543 8.36399 11.82 8.10148C12.2315 7.44957 12.9251 7 13.696 7H16L7 18H5C3.89543 18 3 17.1046 3 16V7.34694Z" fill="white"/>
                                <path d="M9.5 18H19C20.1046 18 21 17.1046 21 16V15H12L9.5 18Z" fill="white"/>
                                <path d="M21 13V9C21 7.89543 20.1046 7 19 7H18.5L13.5 13H21Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.17151 1.12927C5.92175 0.40625 6.93933 0 8.00012 0C9.06091 0 10.0784 0.40625 10.8285 1.12927C11.5786 1.85254 12 2.83337 12 3.85596C12 5.90906 9.21301 8.93323 8.29089 9.87756C8.21521 9.95569 8.10986 10 8 10C7.89014 10 7.78479 9.95569 7.70911 9.87756C6.78699 8.93408 4 5.90881 4 3.85596C4 2.83325 4.42139 1.85242 5.17151 1.12927ZM8 6C9.10461 6 10 5.10461 10 4C10 2.89539 9.10461 2 8 2C6.89539 2 6 2.89539 6 4C6 5.10461 6.89539 6 8 6Z" fill="white"/>
                            </svg>
                        </div>

                        <div class="item-map"></div>
                    </div>
                    <?php
                    $first_item = false;
                    endwhile;
                    wp_reset_postdata();
                ?>
            </div>
            <div class="side">
                <div class="map" id="map"></div>
            </div>
        </div>
    </div>
</section>