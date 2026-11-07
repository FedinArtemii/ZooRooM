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
    wp_enqueue_style('zooroom', get_stylesheet_uri(), [], wp_get_theme()->get('Version'));
    wp_enqueue_script('zooroom', get_theme_file_uri('assets/site.js'), [], wp_get_theme()->get('Version'), true);
});

add_action('wp_head', function () {
    if (is_front_page()) {
        echo '<meta name="description" content="ZooRooM — груминг-салон для собак и кошек в Челябинске. Стрижка, комплексный уход и экспресс-линька. Запись на Труда, 158.">' . "\n";
    }
    printf('<link rel="icon" type="image/svg+xml" href="%s">' . "\n", esc_url(get_theme_file_uri('assets/paw.svg')));
});

function zooroom_link($fragment = '') {
    return esc_url(home_url('/') . $fragment);
}

function zooroom_brand() {
    ?>
    <a class="brand" href="<?php echo zooroom_link(); ?>" aria-label="ZooRooM — главная">
        <img src="<?php echo esc_url(get_theme_file_uri('assets/paw.svg')); ?>" alt="" width="38" height="38">
        <span>Zoo<span>RooM</span></span>
    </a>
    <?php
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_enqueue_scripts', 'wp_enqueue_emoji_styles');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_footer', 'wp_print_speculation_rules');

}
