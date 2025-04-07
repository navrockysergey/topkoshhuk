<?php
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

<div class="vacancie-item">
    <?php
    if ( $departments ) :
        ?>
        <div class="head"><?php echo esc_html( $departments[0]->name )?></div>
        <?php
    endif;
    ?>

    <div class="body">
        <h3><?php echo get_the_title()?></h3>

        <div class="details">
            <?php
            if ( ! empty( $location ) ) :
            ?>
            <div class="datail-item location">
                <span class="icon"></span>

                <?php echo esc_html( $location )?>
            </div>
            <?php
            endif;

            if ( ! empty( $workplace ) ) :
            ?>
            <div class="datail-item workplace">
                <span class="icon"></span>

                <?php echo esc_html( $workplace ) . ','?>

                <?php
                if ( ! empty( $work_days_count ) ) :
                    ?>
                    <span class="shedules">
                        <?php
                        echo $work_days_count;
                        echo '/';
                        echo 7 - intval( $work_days_count );
                        ?>
                    </span>
                    <?php
                endif;
                ?>
            </div>
            <?php
            endif;
            ?>

            <div class="datail-item salary">
                <span class="icon"></span>

                <span class="salary-text">
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
               </span>
            </div>
        </div>
    </div>
</div>