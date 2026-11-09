---
name: ZooRooM — фирменная версия
description: Груминг на тёплой бумаге с цветом и геометрией логотипа
colors:
  paper: "#fffcf5"
  ink: "#102e43"
  muted: "#385366"
  cyan: "#00a1da"
  sky: "#e3f6fc"
  pink: "#b10d65"
  pink-hover: "#8b094e"
  blush: "#fdebf2"
  line: "#adc2c9"
  chrome-line: "#102e4324"
  faq-line: "#b10d6545"
  white: "#ffffff"
  comparison-editorial: "#ecefe3"
typography:
  display:
    fontFamily: "Manrope, sans-serif"
    fontSize: "clamp(2.6rem, 6.45vw, 6rem)"
    fontWeight: 800
    lineHeight: 1.06
    letterSpacing: "-0.04em"
  display-mobile:
    fontFamily: "Manrope, sans-serif"
    fontSize: "clamp(2.35rem, 10vw, 4.1rem)"
    fontWeight: 800
    lineHeight: 1.06
    letterSpacing: "-0.04em"
  headline:
    fontFamily: "Manrope, sans-serif"
    fontSize: "clamp(2.1rem, 5.2vw, 4.6rem)"
    fontWeight: 800
    lineHeight: 1.06
    letterSpacing: "-0.04em"
  title:
    fontFamily: "Manrope, sans-serif"
    fontSize: "clamp(1.5rem, 2.7vw, 2.55rem)"
    fontWeight: 800
    lineHeight: 1.06
    letterSpacing: "-0.04em"
  body:
    fontFamily: "Manrope, sans-serif"
    fontSize: "1rem"
    fontWeight: 500
    lineHeight: 1.6
  button:
    fontFamily: "Manrope, sans-serif"
    fontSize: "0.95rem"
    fontWeight: 800
    lineHeight: 1.35
rounded:
  thumbnail: "8px"
  panel: "16px"
  pill: "100px"
  circle: "50%"
spacing:
  gutter: "clamp(20px, 5.3vw, 88px)"
  section: "clamp(60px, 9vw, 144px)"
  button-gap: "10px"
  service-copy: "clamp(22px, 3vw, 42px)"
components:
  button-primary:
    backgroundColor: "{colors.pink}"
    textColor: "{colors.white}"
    typography: "{typography.button}"
    rounded: "{rounded.pill}"
    padding: "11px 24px"
    height: "50px"
  button-primary-hover:
    backgroundColor: "{colors.pink-hover}"
  button-outline:
    backgroundColor: "transparent"
    textColor: "{colors.ink}"
    typography: "{typography.button}"
    rounded: "{rounded.pill}"
    padding: "11px 24px"
    height: "50px"
  button-outline-hover:
    backgroundColor: "{colors.ink}"
    textColor: "{colors.white}"
  service-card:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.panel}"
  service-card-cat:
    backgroundColor: "{colors.blush}"
  service-card-copy:
    padding: "{spacing.service-copy}"
  faq:
    backgroundColor: "{colors.blush}"
    textColor: "{colors.ink}"
  studio:
    backgroundColor: "{colors.ink}"
    textColor: "{colors.paper}"
  comparison-card:
    backgroundColor: "{colors.sky}"
    rounded: "{rounded.panel}"
  comparison-card-editorial:
    backgroundColor: "{colors.comparison-editorial}"
  comparison-thumbnail-mobile:
    rounded: "{rounded.thumbnail}"
    width: "74px"
---

# Design System — ZooRooM, фирменная версия

## Overview

**Creative North Star** «Круг из логотипа».

Цветной знак ZooRooM задаёт палитру и геометрию. На первом экране крупный заголовок и запись соседствуют с демонстрационным портретом белой мальтийской болонки. Голубой круг и малиновый пунктир обрамляют портрет. Дальше цвет помогает различать услуги, салон и ответы на вопросы.

Система относится к `/brand/` и `/versions/`. Источник стилей — [`theme/zooroom/brand.css`](../../theme/zooroom/brand.css).

**Характерные черты**

- Круглый знак пользователя и белый портрет на голубом круге.
- Тёплая бумага, чернильный текст и отдельные цветовые поля.
- Малиновая запись в ВК и контурная кнопка звонка.

## Colors

Малиновый выделяет основное действие, ссылки журнала и знаки FAQ. Насыщенный голубой отведён графике, а светлый небесный — фону услуг и контактов. Пудрово-розовый выделяет FAQ и карточку кошек. Чернильный служит цветом текста, контуров и фона салона. Шалфейный образец на `/versions/` обозначает редакционную версию.

## Typography

Manrope с локальными кириллическим и латинским файлами. Заголовки, вопросы и действия используют вес 800, основной текст — 500, адрес и даты — 700. Пояснение первого экрана ограничено `30ch`, описания услуг — `48ch`, ответы FAQ — `64ch`.

## Layout

Общий контейнер ограничен `1360px`, сравнение — `1080px`. Первый экран состоит из двух равных колонок с зазором `clamp(16px, 3vw, 56px)` и высотой не меньше `min(820px, calc(100svh - 82px))` на широком экране. Сетка журнала содержит три колонки. При ширине до `820px` первый экран подстраивается по высоте под содержимое, заголовки разделов, журнал, FAQ и контакты складываются в одну колонку. До `680px` в одну колонку переходят первый экран, услуги и сравнение. Запись и адрес стоят перед портретом, его ширина ограничена `360px`. На странице сравнения миниатюра `74px` стоит рядом с текстом, кнопка занимает всю ширину карточки.

## Elevation & Depth

Разделы и карточки плоские. Глубину создают контраст цветовых полей, тонкие разделители и вынос портрета за круг. При наведении кнопка смещается вверх на `2px`, при нажатии масштабируется до `0.98`.

## Shapes

Круглый логотип имеет размер `54px` в шапке, `45px` в узкой шапке и `44px` в подвале. Квадратная композиция портрета ограничена `640px`. Круг отступает от её краёв на `7%`, орбита — на `3.6%`. Орбиту образуют малиновые штрихи по `7deg` с промежутками по `5deg`. Карточки услуг и фото салона скруглены на `16px`, кнопки — на `100px`.

## Components

- **Действия.** Запись в ВК получает сплошную заливку, звонок — чернильный контур. Минимальная высота `50px`, на узком первом экране `48px` с боковыми отступами `15px`. Клавиатурный фокус отмечен контуром `2px` с отступом `4px`.
- **Навигация.** Текстовые ссылки высотой от `44px` подчёркиваются при наведении и фокусе. До `680px` при доступном JavaScript кнопка «Меню» раскрывает список через `aria-expanded`. Ссылка закрывает меню, Escape закрывает его и возвращает фокус кнопке. При отключённом JavaScript ссылки остаются видимыми.
- **Услуги и FAQ.** Карточки услуг используют изображения с соотношением `1.55` и кадрированием `object-fit: cover`. В FAQ нативный `details` раскрывает ответ, а плюс превращается в минус.
- **Движение.** Орбита входит за `1.15s` с поворотом, портрет — за `0.85s` со смещением. Кадр салона раскрывается в диапазоне `entry 3% entry 90%` в браузерах с поддержкой `animation-timeline: view()`. Настройка уменьшенного движения отключает анимации, переходы и плавную прокрутку.
- **WordPress.** Содержимое страниц хранится в нативных блоках `Group`, `Heading`, `Paragraph`, `Image`, `Buttons`, `Button` и `Details`. Сохраняйте классы компоновки и якоря при редактировании. Тема добавляет графику, адаптивность и движение на витрине. Редактор загружает общий `style.css`, поэтому внешний вид фирменной версии проверяют в предпросмотре страницы.

## Do's and Don'ts

- **Сохраняйте** предоставленный цветной знак и видимую подпись о демонстрационных изображениях.
- **Оставляйте** запись в ВК первым действием, а телефон — рядом.
- **Проверяйте** клавиатурный фокус, раскрытие FAQ и настройку уменьшенного движения в предпросмотре.
