<?php
$vacanсies = apply_filters( 'get_vacancies', false );

if ( ! $vacanсies->have_posts() ) {
    // TODO: Create window  
    echo "Vacansies not fount";
    return;
}

?>

<section class="vacansies-wrap">
    <?php
    if ( ! empty( $vacancies_block_title ) ) :
    ?>
    <h2 class="section-title"><?php echo esc_html( $vacancies_block_title )?></h2>
    <?php
    endif;
    
    if ( ! empty( $vacancies_block_offers ) ) :
        ?>
        <div class="offers-wrap">
        <?php
            foreach( $vacancies_block_offers as $offer ) :
                ?>
                <div class="offer-item">
                    <span class="icon"></span>

                    <span class="offer-title">
                        <?php echo esc_html( $offer['single_offer'] )?>
                    </span>
                </div>
                <?php
            endforeach;
        ?>
        </div>
        <?php
    endif;    
    ?>

    <div class="vacancies-wrap">
        <?php
        while( $vacanсies->have_posts() ) :
            $vacanсies->the_post();

            include __THEME_DIR__ . '/template-parts/blocks/vacancie-item.php';
        endwhile;
        ?>
    </div>
</section>

<?php
