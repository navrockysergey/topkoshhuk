<?php
/*
Template Name: 404
*/
?>

<?php get_header(); ?>

<main id="main" class="site-main page-404">
    <section class="section section-content section-404">
        <div class="container breadcrumb-container">
            <?php
                if ( function_exists('yoast_breadcrumb') ) {
                    yoast_breadcrumb( '<div id="breadcrumbs">','</div>' );
                }
            ?>
        </div>
        <div class="container container-404">
            <?php
				$specific_post_id = 286;
				$specific_post = get_post( $specific_post_id );
				if ( $specific_post ) {
					echo apply_filters( 'the_content', $specific_post->post_content );
				}
            ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
