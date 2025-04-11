<?php
/* 
Template Name: Page
*/

get_header();

?>

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
