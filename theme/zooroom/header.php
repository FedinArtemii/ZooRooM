<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">К содержанию</a>
<header class="site-header">
    <div class="shell header-inner">
        <?php zooroom_brand(); ?>
        <button class="menu-toggle" type="button" aria-controls="site-nav" aria-expanded="false">Меню <span aria-hidden="true"></span></button>
        <nav id="site-nav" class="site-nav" aria-label="Основное меню">
            <a href="<?php echo zooroom_link('#services'); ?>">Услуги</a>
            <a href="<?php echo zooroom_link('#studio'); ?>">О салоне</a>
            <a href="<?php echo zooroom_link('#contacts'); ?>">Контакты</a>
        </nav>
    </div>
</header>
