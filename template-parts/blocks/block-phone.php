<?php if ( get_theme_mod( 'phone' ) ) : ?>
    <a href="tel:<?php echo preg_replace('/\D/', '', get_theme_mod( 'phone' ) ); ?>">
        <?php 
            $phone = esc_html( get_theme_mod( 'phone' ) );
            $phone = preg_replace('/\(/', '<span>(', $phone, 1);
            $phone = preg_replace('/\)/', ')</span>', $phone, 1);
            echo $phone;
        ?>
    </a>
<?php endif; ?>
<?php if ( get_theme_mod( 'phone_2' ) ) : ?>
    <a href="tel:<?php echo preg_replace('/\D/', '', get_theme_mod( 'phone_2' ) ); ?>">
        <?php 
            $phone = esc_html( get_theme_mod( 'phone' ) );
            $phone = preg_replace('/\(/', '<span>(', $phone, 1);
            $phone = preg_replace('/\)/', ')</span>', $phone, 1);
            echo $phone;
        ?>
    </a>
<?php endif; ?>