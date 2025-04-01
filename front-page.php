<?php
get_header();
?>

<main id="primary" class="site-main">

    <?php if (get_the_content()) : ?>
        <?php
            apply_filters( 'the_content', the_content() ); ?>
    <?php endif; ?>

</main>

<?php
get_footer();