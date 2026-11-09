<?php
$brand_hero = zr_group(
    zr_group(
        zr_heading('Груминг для<br>собак и кошек', 1) .
        zr_text('Стрижка, гигиенический уход и экспресс-линька.', 'brand-intro') .
        zr_buttons(zr_button('Написать в ВК', $message), zr_button('Позвонить', $phone, 'button-outline')) .
        zr_text('Челябинск · ул. Труда, 158', 'hero-address'),
        'brand-intro-copy'
    ) .
    zr_group(zr_image('maltese', 'Белая собака с малиновым бантом', 'brand-portrait', 'brand'), 'brand-art'),
    'brand-hero', 'home', 'section'
);

$brand_services = zr_group(
    zr_group(
        zr_heading('Какой уход нужен?') .
        zr_text('Расскажите о породе и желаемых процедурах при записи. Подскажем, сколько займёт уход и сколько он будет стоить.'),
        'section-heading'
    ) .
    zr_group(
        zr_group(
            zr_image('dog', 'Золотистый спаниель', 'brand-service-photo') .
            zr_group(
                zr_heading('Для собак', 3) .
                zr_text('Мытьё, сушка и стрижка по породе или по вашим пожеланиям. В комплекс входит гигиенический уход.'),
                'service-copy', 'dog-care'
            ),
            'brand-service brand-service-dog', '', 'article'
        ) .
        zr_group(
            zr_image('cat', 'Серая кошка', 'brand-service-photo') .
            zr_group(
                zr_heading('Для кошек', 3) .
                zr_text('Стрижка или вычёсывание шерсти, уход за когтями, ушами и глазами. Подберём подходящий комплекс.'),
                'service-copy', 'cat-care'
            ),
            'brand-service brand-service-cat', '', 'article'
        ),
        'brand-service-grid'
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

$brand_journal = zr_group(
    zr_group(
        zr_heading('Заметки грумера') .
        zr_text('<a href="' . $vk . '">Все публикации ВКонтакте</a>', 'story-link'),
        'section-heading'
    ) . zr_group($brand_story_cards, 'story-grid'),
    'section journal', 'journal', 'section'
);
$brand_content = $brand_hero . $brand_services . $studio . $brand_journal . $faq .
    str_replace('&nbsp; ↗', '', $contacts);

zr_save('page', 'brand', 'ZooRooM — груминг для собак и кошек',
    $brand_content
);

$comparison = zr_group(
    zr_heading('Два дизайна ZooRooM', 1) .
    zr_text('Откройте оба варианта сайта груминг-салона, чтобы сравнить их.', 'compare-intro') .
    zr_group(
        zr_group(
            zr_image('poodle', '', 'compare-image') .
            zr_heading('Спокойный редакционный', 2) .
            zr_text('Шалфейные оттенки, крупные портреты и журнальная типографика.') .
            zr_buttons(zr_button('Открыть первый вариант', home_url('/'), 'button-outline')),
            'compare-card compare-editorial', '', 'article'
        ) .
        zr_group(
            zr_image('maltese', '', 'compare-image', 'brand') .
            zr_heading('Яркий фирменный', 2) .
            zr_text('Голубой и малиновый из логотипа, круговая графика и крупный шрифт.') .
            zr_buttons(zr_button('Открыть второй вариант', home_url('/brand/'), 'button-outline')),
            'compare-card compare-brand', '', 'article'
        ),
        'compare-grid'
    ),
    'comparison', '', 'section'
);
zr_save('page', 'versions', 'Два дизайна ZooRooM', $comparison);
