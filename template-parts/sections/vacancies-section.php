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
        
        if ( ! empty( $vacancies_block_offers ) ) :
            ?>
            <div class="offers">
            <?php
                foreach( $vacancies_block_offers as $offer ) :
                    ?>
                    <div class="item">
                        <?php echo esc_html( $offer['single_offer'] )?>
                    </div>
                    <?php
                endforeach;
            ?>
            </div>
            <?php
        endif;   
        
        if ( ! $vacanсies->have_posts() ) {
            echo '<div class="vacancies-empty">';
            echo '<h3>' . __('Зараз розміщених вакансій немає.') . '</h3>';
            echo '<p>' . __('Ви можете залишити нам своє резюме і ми звернемося до вас у випадку появи підходящої вам вакансії.') . '</p>';
            echo '</div>';
        }

        ?>

        <div class="vacancies">
            <?php
            while( $vacanсies->have_posts() ) :
                $vacanсies->the_post();

                include __THEME_DIR__ . '/template-parts/blocks/vacancie-item.php';
            endwhile;
            ?>
        </div>

        <?php
        if ( $inner_blocks && ! empty( $inner_blocks ) ) :
            ?>
                <?php
                if ( ! empty( $vacancies_second_block_title ) ) :
                    ?>
                    <h2 class="section-title"><?php echo esc_html( $vacancies_second_block_title )?></h2>
                    <?php
                endif;

                echo $inner_blocks;
                ?>
            <?php
        endif; ?>

    </div>
</section>