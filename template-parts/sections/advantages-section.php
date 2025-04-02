<?php
$advantages = carbon_get_theme_option( 'advantages_list' );

if ( empty( $advantages ) ) {
    return;
}
?>
<section class="section section-advantages">
    <div class="container">
        <div class="advantage-items">
        <?php
        foreach( $advantages as $advantage ) :
            $icon_type    = $advantage['adv_icon_type'];
            $icon_img_src = $advantage['adv_icon_image'];
            $icon_code    = $advantage['adv_icon_code'];
            $title        = $advantage['adw_title'];
            $desc         = $advantage['adw_desc_text'];

            $icon = 'image' == $icon_type ? "<img class='icon-image' src='{$icon_img_src}' alt='{$title}'>" : $icon_code ;
            ?>
                <div class="advantage-item">
                    <div class="advantage-item-icon">
                        <?php echo $icon?>
                    </div>

                    <div class="advantage-item-title">
                        <?php echo $title?>
                    </div>

                    <div class="advantage-item-description">
                        <?php echo $desc?>
                    </div>
                </div>
            <?php
        endforeach;
        ?>
        </div>
    </div>
</section>