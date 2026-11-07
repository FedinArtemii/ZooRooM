<?php
// Seed editable core blocks. Run on a fresh WordPress installation.
function zr_block($name, $html, $attributes = []) {
    $json = $attributes ? ' ' . serialize_block_attributes($attributes) : '';
    return "<!-- wp:$name$json -->\n$html\n<!-- /wp:$name -->\n\n";
}

function zr_group($children, $class = '', $anchor = '', $tag = 'div') {
    $attributes = array_filter([
        'tagName' => $tag === 'div' ? '' : $tag,
        'anchor' => $anchor,
        'className' => $class,
    ]);
    $id = $anchor ? ' id="' . esc_attr($anchor) . '"' : '';
    $classes = trim("wp-block-group $class");
    return zr_block('group', "<$tag$id class=\"$classes\">\n$children</$tag>", $attributes);
}

function zr_heading($text, $level = 2, $class = '') {
    $attributes = $level === 2 ? [] : ['level' => $level];
    if ($class) {
        $attributes['className'] = $class;
    }
    $classes = trim("wp-block-heading $class");
    return zr_block('heading', "<h$level class=\"$classes\">$text</h$level>", $attributes);
}

function zr_text($text, $class = '') {
    $attributes = $class ? ['className' => $class] : [];
    $class_html = $class ? " class=\"$class\"" : '';
    return zr_block('paragraph', "<p$class_html>$text</p>", $attributes);
}

function zr_image($asset, $alt, $class = '') {
    $url = esc_url(get_theme_file_uri("assets/editorial/$asset.webp"));
    $alt = esc_attr($alt);
    $attributes = $class ? ['className' => $class] : [];
    $classes = trim("wp-block-image $class");
    return zr_block('image', "<figure class=\"$classes\"><img src=\"$url\" alt=\"$alt\"/></figure>", $attributes);
}

function zr_button($label, $url, $class = '') {
    $url = esc_url($url);
    $classes = trim("wp-block-button $class");
    return zr_block('button', "<div class=\"$classes\"><a class=\"wp-block-button__link wp-element-button\" href=\"$url\">$label</a></div>", $class ? ['className' => $class] : []);
}

function zr_buttons(...$buttons) {
    return zr_block('buttons', '<div class="wp-block-buttons">' . implode($buttons) . '</div>');
}

function zr_details($label, $body) {
    return zr_block('details', "<details class=\"wp-block-details\"><summary>$label</summary>\n" . zr_text($body) . '</details>');
}

function zr_save($type, $slug, $title, $content, $extra = []) {
    $existing = get_page_by_path($slug, OBJECT, $type);
    if ($existing) {
        return $existing->ID;
    }

    $id = wp_insert_post(wp_slash(array_merge([
        'post_type' => $type,
        'post_name' => $slug,
        'post_title' => $title,
        'post_content' => $content,
        'post_status' => 'publish',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
    ], $extra)), true);

    if (is_wp_error($id)) {
        throw new RuntimeException($id->get_error_message());
    }
    return $id;
}

$vk = 'https://vk.ru/zooroom_chelyabinsk';
$message = 'https://vk.me/zooroom_chelyabinsk';
$phone = 'tel:+79954601020';
$map = 'https://yandex.ru/maps/org/zooroom/238105854151/';

$hero = zr_group(
    zr_group(
        zr_heading('Бережный груминг <br>для собак и кошек', 1) .
        zr_buttons(zr_button('Написать в ВК', $message), zr_button('Позвонить', $phone, 'button-outline')) .
        zr_text('Челябинск · ул. Труда, 158', 'hero-address'),
        'hero-copy'
    ) .
    zr_group(zr_image('poodle', 'Портрет светлого пуделя', 'hero-image'), 'hero-art') .
    zr_text('<a href="#services">Выбрать уход</a>', 'hero-discover'),
    'hero', 'home', 'section'
);

$services_section = zr_group(
    zr_group(
        zr_heading('Уход для вашего питомца') .
        zr_text('Назовите породу и нужные процедуры при записи. Подскажем, сколько займёт уход и сколько он будет стоить.'),
        'section-heading'
    ) .
    zr_group(
        zr_text('<a href="#dog-care">Уход за собаками</a>') . zr_text('<a href="#cat-care">Уход за кошками</a>'),
        'care-strip'
    ) .
    zr_group(
        zr_group(
            zr_heading('Для собак', 3) .
            zr_text('Мытьё, сушка и стрижка по породе или по вашим пожеланиям. В комплекс входит гигиенический уход.'),
            'service-copy', 'dog-care'
        ) .
        zr_image('dog', 'Золотистый спаниель на льняной скамье', 'service-photo'),
        'service-card', '', 'article'
    ) .
    zr_group(
        zr_group(
            zr_heading('Для кошек', 3) .
            zr_text('Стрижка или вычёсывание шерсти, уход за когтями, ушами и глазами. Подберём подходящий комплекс.'),
            'service-copy', 'cat-care'
        ) .
        zr_image('cat', 'Серая кошка на льняной ткани', 'service-photo'),
        'service-card service-card--cat', '', 'article'
    ) .
    zr_group(
        zr_group(
            zr_heading('Экспресс-линька', 3) .
            zr_text('Для собак и кошек. Вычёсываем выпадающий подшёрсток с учётом типа и состояния шерсти.'),
            'service-extra'
        ) .
        zr_group(
            zr_heading('Чистка зубов', 3) .
            zr_text('Ультразвуковая чистка для собак без наркоза. Подходит ли процедура питомцу, уточните при записи.'),
            'service-extra'
        ),
        'service-extras'
    ),
    'section services', 'services', 'section'
);

$studio = zr_group(
    zr_group(
        zr_heading('У каждого питомца свой характер') .
        zr_text('В ZooRooM стрижём собак и кошек, помогаем с сезонной линькой и подбираем одежду для собак. Перед визитом расскажите мастеру о привычках питомца и о том, как он переносит уход.'),
        'section-heading studio-copy'
    ) . zr_image('studio', 'Демонстрационная сцена ухода за шерстью собаки', 'studio-photo'),
    'section studio', 'studio', 'section'
);

$stories = [
    [
        'cat-shedding', 'Когда кошка линяет', '2026-08-29', '6003',
        'Что входит в экспресс-линьку и о чём стоит рассказать мастеру до визита.',
        [
            'Когда шерсть остаётся на мебели и одежде, в ZooRooM предлагают экспресс-линьку. Мастер вычёсывает уже выпадающую шерсть специальными инструментами. В публикации салон описывает эту процедуру как часть комплекса ухода.',
            'В публикации указан ориентир в полтора–два часа. При записи сообщите о колтунах и о том, как кошка переносит вычёсывание. Мастер подскажет, сколько времени заложить на визит.',
        ],
    ],
    [
        'yorkie-coat', 'Как ухаживать за шерстью йорка', '2026-08-05', '6002',
        'Зачем йорку регулярный уход и как салон подбирает средства для мытья.',
        [
            'Шерсть йорка требует регулярного ухода. В публикации мастера ZooRooM обращают внимание на участки, которые пачкаются чаще всего: лапы после прогулки, бороду и живот после еды или дождя.',
            'Частоту мытья и средства подбирают с учётом состояния кожи и шерсти. На визите можно рассказать грумеру о домашнем уходе и обсудить подходящие средства.',
        ],
    ],
    [
        'shedding-results', 'От чего зависит результат экспресс-линьки', '2026-06-14', '5997',
        'Тип шерсти, стадия линьки и поведение питомца влияют на результат процедуры.',
        [
            'В ZooRooM обращают внимание на три вещи: тип шерсти, стадию линьки и то, как питомец ведёт себя во время процедуры. Если подшёрсток густой и животное спокойно переносит вычёсывание, мастер может тщательнее проработать шерсть.',
            'Во время процедуры убирают шерсть, которая уже начала выпадать. Естественное обновление шерсти продолжается и после визита.',
        ],
    ],
];
global $wp_rewrite;
$wp_rewrite->set_permalink_structure('/journal/%postname%/');
update_option('timezone_string', 'Asia/Yekaterinburg');
$story_cards = '';
foreach ($stories as [$slug, $title, $date, $source, $excerpt, $paragraphs]) {
    $source_link = 'https://vk.ru/wall-50965296_' . $source;
    $mirror = 'https://zooroom-chelyabinsk.orgs.biz/news/' . $source;
    $post = zr_save('post', $slug, $title,
        implode(array_map('zr_text', $paragraphs)) .
        zr_text('<a href="' . $source_link . '">Публикация ВКонтакте</a> · <a href="' . $mirror . '">Копия в архиве салона</a>', 'story-sources') .
        zr_buttons(zr_button('Записаться&nbsp; ↗', home_url('/#contacts'))),
        ['post_date' => "$date 12:00:00"]
    );
    $url = esc_url(get_permalink($post));
    $story_cards .= zr_group(
        zr_text(get_the_date('d.m.Y', $post), 'eyebrow') .
        zr_heading('<a href="' . $url . '">' . esc_html($title) . '</a>', 3) .
        zr_text($excerpt) .
        zr_text('<a href="' . $url . '" aria-label="Читать: ' . esc_attr($title) . '">Читать&nbsp; ↗</a>', 'story-link'),
        'story-card', '', 'article'
    );
}
$journal = zr_group(
    zr_group(
        zr_heading('Заметки грумера') .
        zr_text('<a href="' . $vk . '">Все публикации ВКонтакте&nbsp; ↗</a>', 'story-link'),
        'section-heading'
    ) . zr_group($story_cards, 'story-grid'),
    'section journal', 'journal', 'section'
);

$faq = zr_group(
    zr_heading('Перед визитом') .
    zr_group(
        zr_details('Нужно ли готовить питомца?', 'Специальная подготовка обычно не нужна. Заранее расскажите мастеру об особенностях поведения питомца и о том, какие процедуры он переносит с трудом.') .
        zr_details('Что входит в комплекс для собак?', 'Комплекс зависит от породы. Обычно он включает мытьё, сушку, стрижку или вычёсывание, уход за когтями, ушами и глазами. Состав уточним при записи.') .
        zr_details('Можно ли привести корги?', 'Да. Для корги подбираем уход за шерстью, лапами, когтями, ушами и глазами. Окантовку можно обсудить с мастером.') .
        zr_details('Можно ли записать кошку на стрижку?', 'Да. Для кошек доступны стрижка, экспресс-линька и гигиенический уход. Сообщите заранее, если у кошки есть колтуны.') .
        zr_details('Как узнать стоимость и записаться?', 'Напишите в сообщения группы или позвоните. Назовите породу и желаемые процедуры. Мастер сориентирует по стоимости и предложит свободное время.'),
        'faq-list'
    ),
    'section faq', 'faq', 'section'
);

$contacts = zr_group(
    zr_group(
        zr_heading('Запишитесь на груминг') .
        zr_text('Расскажите, кого ждём в гости и какой уход нужен. Предложим удобное время.') .
        zr_buttons(zr_button('Написать в ВК', $message), zr_button('Позвонить', $phone, 'button-outline')),
        'contact-copy'
    ) .
    zr_group(
        zr_heading('Челябинск, ул. Труда, 158', 3) .
        zr_text('Цокольный этаж · ежедневно, 10:00–20:00') .
        zr_text('<a href="' . $phone . '">+7 (995) 460-10-20</a>', 'contact-phone') .
        zr_text('<a href="' . $map . '">Открыть на Яндекс Картах&nbsp; ↗</a>', 'story-link'),
        'contact-card'
    ),
    'section contacts', 'contacts', 'section'
);

$home = zr_save('page', 'home', 'ZooRooM — груминг-салон в Челябинске',
    $hero . $services_section . $studio . $journal . $faq . $contacts
);
update_option('show_on_front', 'page');
update_option('page_on_front', $home);
update_option('blogname', 'ZooRooM');
update_option('blogdescription', '');
update_option('WPLANG', 'ru_RU');
update_option('blog_public', 0);
update_option('default_comment_status', 'closed');
flush_rewrite_rules(false);
