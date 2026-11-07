<?php get_header(); ?>
<main id="main" class="shell">
    <article class="article">
        <a class="back-link" href="<?php echo zooroom_link('#journal'); ?>">← На главную</a>
        <?php while (have_posts()) : the_post(); ?>
            <?php if (is_singular('post')) : ?>
                <p class="eyebrow">Журнал ZooRooM <span aria-hidden="true">✦</span> <?php echo esc_html(get_the_date('d.m.Y')); ?></p>
            <?php endif; ?>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        <?php endwhile; ?>
    </article>
</main>
<?php get_footer(); ?>
