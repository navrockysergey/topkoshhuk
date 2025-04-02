<?php
    $main_top_heading_text  = ! empty( $main_top_heading_text ) ? esc_html( $main_top_heading_text ) : get_the_title();
?>
<section class="section section-main" id="main-top">
    <div class="rows">
        <div class="row">
            <div class="container">
                <!-- TODO: Search input here -->

                <?php
                if ( 'text' == $main_top_heading_type ) :
                ?>
                <h1 class="post-title">
                    <?php echo $main_top_heading_text?>
                </h1>
                <?php
                endif;
                ?>
            </div> <!-- .container -->
        </div> <!-- .row -->

        <div class="row">
            <?php echo apply_filters( 'the_content', $inner_blocks )?>
        </div> <!-- .row -->

        <div class="row">
            <div class="container">
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
                    <a href="<?php echo esc_url( $main_bottom_button_link )?>" class="button">
                        <?php echo esc_html( $main_bottom_button_text )?>
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
            </div> <!-- .container -->
        </div> <!-- .row -->
    </div> <!-- .rows -->
</section>