<?php
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_enqueue_scripts', 'wp_enqueue_emoji_styles');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_footer', 'wp_print_speculation_rules');

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('editor-styles');
    add_editor_style('style.css');
});

add_action('wp_enqueue_scripts', function () {
    if (zooroom_brand_demo()) {
        wp_enqueue_style('zooroom-brand', get_theme_file_uri('brand.css'), [], '1.0.0');
    } else {
        wp_enqueue_style('zooroom', get_stylesheet_uri(), [], wp_get_theme()->get('Version'));
    }
    wp_enqueue_script('zooroom', get_theme_file_uri('assets/site.js'), [], wp_get_theme()->get('Version'), true);
    if (zooroom_brand_demo()) {
        wp_enqueue_script('zooroom-brand-menu', get_theme_file_uri('assets/brand/menu.js'), ['zooroom'], '1.0.0', true);
    }
});

add_action('wp_head', function () {
    if (is_front_page() || is_page('brand')) {
        echo '<meta name="description" content="ZooRooM — груминг-салон для собак и кошек в Челябинске. Стрижка, комплексный уход и экспресс-линька. Запись на Труда, 158.">' . "\n";
    }
    if (is_page('versions')) {
        echo '<meta name="description" content="Два варианта дизайна сайта груминг-салона ZooRooM в Челябинске.">' . "\n";
    }
    if (zooroom_brand_demo()) {
        printf('<link rel="icon" type="image/webp" href="%s">' . "\n", esc_url(get_theme_file_uri('assets/brand/logo.webp')));
    } else {
        printf('<link rel="icon" type="image/svg+xml" href="%s">' . "\n", esc_url(get_theme_file_uri('assets/paw.svg')));
    }
});

function zooroom_brand_demo() {
    return is_page(['brand', 'versions']);
}

add_filter('template_include', function ($template) {
    return zooroom_brand_demo() ? get_theme_file_path('front-page.php') : $template;
});

function zooroom_link($fragment = '') {
    return esc_url(home_url(zooroom_brand_demo() ? '/brand/' : '/') . $fragment);
}

function zooroom_brand() {
    ?>
    <a class="brand" href="<?php echo zooroom_link(); ?>" aria-label="ZooRooM — главная">
<?php if (zooroom_brand_demo()) : ?>
        <img width="54" height="54" src="<?php echo esc_url(get_theme_file_uri('assets/brand/logo.webp')); ?>" alt="">
<?php endif; ?>
        ZooRooM
    </a>
    <?php
}
