<?php
$stores = apply_filters( 'get_stores', false );

if ( ! $stores->have_posts() ) {
    return;
}

?>

<section class="stores">
    <div class="container">
        <?php
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
        <div class="store-item flex" data-lat="<?php echo esc_attr( $latitude )?>" data-lng="<?php echo esc_attr( $longitude )?>">
            <div class="side">
                <img src="<?php echo esc_url( $thumbnail )?>" alt="<?php echo $title?>">
            </div>

            <div class="side">
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
                    if ( ! empty ( $shedule_before_string ) ) {
                        echo $shedule_before_string . ' ,';
                    }
                    
                    echo $time_work_start . ' - ' . $time_work_end;
                    ?>
                </div>
                <?php
                endif;

                if( ! empty( $phones ) ) :
                ?>
                <div class="contact-phones-wrap">
                    <?php
                    foreach( $phones as $phone ) :
                        $sanitise_phone = preg_replace('/\D/', '', $phone['contact_number'] );
                    ?>
                    <a href="tel:<?php echo $sanitise_phone ?>" target="_blank"><?php echo esc_html( $phone['contact_number'] )?></a>
                    <?php
                    endforeach;
                    ?>
                </div>
                <?php
                endif;
                ?>
            </div>
        </div>
        <?php
        endwhile;
        ?>
    </div>
</section>