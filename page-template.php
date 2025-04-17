<?php
/* 
Template Name: Page
*/

get_header();

?>

<div class="breadcrumb-container">
    <div class="container">
        <?php
            if ( function_exists('yoast_breadcrumb') ) {
                yoast_breadcrumb( '<div id="breadcrumbs">','</div>' );
            }
        ?>
    </div>
</div>

<div class="header-title">
    <div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</div>

<section class="section section-page">
    <div class="container">
        <?php if (get_the_content()) : ?>
            <div class="content">
                <?php the_content(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer();
