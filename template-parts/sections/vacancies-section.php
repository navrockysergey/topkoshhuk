<?php
$vacanсies = apply_filters( 'get_vacancies', false );
?>

<section class="section section-vacancies">
    <div class="container">
        <?php
        if ( ! empty( $vacancies_block_title ) ) :
        ?>
        <h2 class="section-title"><?php echo esc_html( $vacancies_block_title )?></h2>
        <?php
        endif;

        if ( ! $vacanсies->have_posts() ) {
            // TODO: Create window  
            echo '<div class="vacancies-empty">';
            echo '<h3>' . __('Зараз розміщених вакансій немає.') . '</h3>';
            echo '<p>' . __('Ви можете залишити нам своє резюме і ми звернемося до вас у випадку появи підходящої вам вакансії.') . '</p>';
            echo '</div>';
            return;
        }
        
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
    </div>
</section>

<?php
if ( $inner_blocks && ! empty( $inner_blocks ) ) :
    ?>
    <section class="section section-vacancies">
        <div class="container">
            <?php
            if ( ! empty( $vacancies_second_block_title ) ) :
                ?>
                <h2 class="section-title"><?php echo esc_html( $vacancies_second_block_title )?></h2>
                <?php
            endif;

            echo $inner_blocks;
            ?>
        </div>
    </section>
    <?php
endif;
