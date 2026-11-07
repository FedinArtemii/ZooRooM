<?php get_header(); ?>
<main id="main" class="home-content">
    <?php while (have_posts()) : the_post(); the_content(); endwhile; ?>
</main>
<?php get_footer(); ?>
