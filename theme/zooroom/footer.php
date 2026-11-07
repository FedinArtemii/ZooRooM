<footer class="site-footer">
    <div class="shell footer-inner">
        <?php zooroom_brand(); ?>
        <p>Груминг-салон в Челябинске</p>
        <a href="<?php echo zooroom_link('#journal'); ?>">Журнал</a>
        <a href="https://vk.ru/zooroom_chelyabinsk">ВКонтакте</a>
        <?php if (is_front_page()) : ?>
            <p class="media-note">Изображения для демоверсии сгенерированы.</p>
        <?php endif; ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
