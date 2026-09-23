#!/usr/bin/env python3
"""Generate the page field groups in sweet-pepper-theme/acf-json/.

    python3 tools/page-field-groups.py

  group_sp_about.json    — the About page's fields: one tab per section, on Page Template = About
                           (a tab per section, all eleven sections since 21 Sep 2026)
  group_sp_location.json — the location headline every page shares, on Bar Settings
  group_sp_pairings.json — the dish picker's rows, on the one `pairings` record

Sections are added as they leave the templates (website-brief.md → Content editing →
About fields): lists first, prose after. A tab exists only once its template reads it —
a field is a promise.

Every text has an `_ru` / `_en` twin, RU on the left; the theme prints one language per
request and borrows the other for a twin left empty (inc/fields.php). Field names are read
by sweet-pepper-theme/inc/about-data.php, inc/location.php and tools/page-seed.php.
"""
from scf_fields import field, text, area, toggle, select, group, write_groups


def twins(f, key, label, name, type_="text", preset=None, **extra):
    """An RU / EN pair, side by side. A note is repeated on the twin on purpose:
    a note on one side only leaves the pair uneven."""
    preset = preset if preset is not None else (area if type_ == "textarea" else text)
    return [
        f(f"{key}_ru", label, f"{name}_ru", type_, 50, **{**preset, **extra}),
        f(f"{key}_en", f"{label} (EN)", f"{name}_en", type_, 50, **{**preset, **extra}),
    ]


def section_header(f, key, name, description=True):
    """The section-header component: eyebrow, a headline of one or two lines, a description."""
    return [
        *twins(f, f"{key}_eyebrow", "Надзаголовок", f"{name}_eyebrow"),
        *twins(f, f"{key}_headline", "Заголовок · строка 1", f"{name}_headline"),
        *twins(f, f"{key}_headline_2", "Заголовок · строка 2", f"{name}_headline_2", placeholder="можно без второй строки"),
        *(twins(f, f"{key}_description", "Текст", f"{name}_description", "textarea", rows=3) if description else []),
    ]


# ── About ── one tab per section, in page order
A = "field_sp_about_"
a = lambda *args, **k: field(*args, prefix=A, **k)
rep = lambda parent: (lambda *args, **k: field(*args, prefix=A, parent=parent, **k))
image = dict(return_format="id", library="all", min_width="", min_height="", min_size="", max_width="",
             max_height="", max_size="", mime_types="jpg,jpeg,png,webp", preview_size="medium")
year = dict(default_value="", min=2009, max="", step=1, placeholder="", prepend="", append="")
url = dict(default_value="", placeholder="")
hidden_id = lambda f, key, name: f(key, "ID", name, "text", "", wrapper_class="sp-field-hidden", readonly=1, **text)

def tab(key, label):
    return a(f"{key}_tab", label, "", "tab", placement="top", endpoint=0)

def hint(key, message):
    return a(f"{key}_hint", "", "", "message", message=message, new_lines="", esc_html=0)

def repeater(key, label, name, sub_fields, button, min=0, max=0, layout="block", collapsed=""):
    return a(key, label, name, "repeater", layout=layout, pagination=0, min=min, max=max,
             collapsed=collapsed, button_label=button, rows_per_page=20, sub_fields=sub_fields)

# 1. Hero
hero = [
    tab("hero", "Первый экран"),
    *twins(a, "hero_eyebrow", "Надзаголовок — адрес", "about_hero_eyebrow"),
    *twins(a, "hero_headline", "Заголовок · строка 1", "about_hero_headline"),
    # Line 2 runs on after line 1 on desktop; tablets and phones stack it in Paprika (Figma 2559:70744)
    *twins(a, "hero_headline_2", "Заголовок · строка 2", "about_hero_headline_2", placeholder="на телефоне — вторая строка другим цветом"),
    *twins(a, "hero_lead", "Текст", "about_hero_lead", "textarea"),
]

# 2. Concept (the picker's pairings are their own record; its title and subtitle are component strings)
concept = [tab("concept", "Бар и кухня"), *section_header(a, "concept", "about_concept")]

# 3. How it feels — the quotes. The words, their tiers and sizes are NOT here: they come
# from the review tally (website-brief.md → "How it feels" — reviews pipeline), and the
# honesty contract forbids hand-picking a word. WORDS is the current list, for the
# dropdown; regenerate when the tally changes.
WORDS = ["cosy", "welcoming", "beloved", "friendly", "happy", "attentive", "perfect", "inviting", "magnetic",
         "sociable", "wonderful", "lively", "pleasant", "charming", "kind", "inclusive"]
q = rep("quotes")
reviews = [
    tab("reviews", "Отзывы"),
    *section_header(a, "reviews", "about_reviews", description=False),
    hint("quotes", "Цитаты из отзывов — короткие выдержки, не отзыв целиком; без имён авторов. Каждая привязана к слову "
                   "из облака; у слова должна остаться хотя бы одна цитата. Порядок строк — порядок в ленте. "
                   "Сноска — одна строка от бара, необязательна."),
    repeater("quotes", "Цитаты", "about_quotes", [
        q("quote_text_ru", "Цитата — оригинал", "text_ru", "textarea", 50, required=1, **{**area, "rows": 3}),
        q("quote_text_en", "Цитата (EN)", "text_en", "textarea", 50, **{**area, "rows": 3}),
        q("quote_word", "Слово", "word", "select", 25, choices={w: w for w in WORDS}, default_value="", allow_null=0, **select),
        q("quote_platform", "Площадка", "platform", "select", 25,
          choices={"Yandex": "Яндекс", "Google": "Google", "2GIS": "2ГИС"}, default_value="Yandex", allow_null=0, **select),
        q("quote_date", "Дата отзыва", "date", "date_picker", 25, display_format="d.m.Y", return_format="Y-m-d", first_day=1),
        q("quote_link", "Ссылка на отзыв", "link", "url", 25, **url),
        *twins(q, "quote_footnote", "Сноска", "footnote"),
        hidden_id(q, "quote_id", "quote_id"),
    ], "Добавить цитату", collapsed=f"{A}quote_text_ru"),
]

# 4. Perks — exactly six stamps; the colours are dealt by the theme.
ICONS_PERK = {"wifi": "Wi-Fi", "kids": "Дети", "dog": "Собака", "sun": "Солнце", "star": "Звезда", "accessible": "Доступность"}
pk = rep("perks")
perks = [
    tab("perks", "Удобства"),
    *section_header(a, "perks", "about_perks", description=False),
    hint("perks", "Ровно шесть кружков-штампов, порядок строк — порядок на сайте. «В кружке» — слово на компьютере, "
                  "«В кружке (телефон)» — короче, для узких экранов. Заголовок и пояснение показываются под кружками."),
    repeater("perks", "Штампы", "about_perks", [
        pk("perk_icon", "Значок", "icon", "select", 20, choices=ICONS_PERK, default_value="wifi", allow_null=0, **select),
        pk("perk_label_ru", "В кружке", "label_ru", "text", 20, required=1, **text),
        pk("perk_label_en", "В кружке (EN)", "label_en", "text", 20, **text),
        pk("perk_word_ru", "В кружке (телефон)", "word_ru", "text", 20, **text),
        pk("perk_word_en", "В кружке (телефон, EN)", "word_en", "text", 20, **text),
        *twins(pk, "perk_title", "Заголовок", "title"),
        *twins(pk, "perk_description", "Пояснение", "description", "textarea"),
    ], "Добавить штамп", min=6, max=6, collapsed=f"{A}perk_label_ru"),
]

# 5. Story
ms, ct = rep("milestones"), rep("counters")
story = [
    tab("story", "История"),
    *section_header(a, "story", "about_story", description=False),
    *twins(a, "story_p1", "Абзац 1", "about_story_p1", "textarea", rows=4),
    *twins(a, "story_p2", "Абзац 2 — на телефоне идёт после хронологии", "about_story_p2", "textarea", rows=4),
    *twins(a, "story_p3", "Абзац 3", "about_story_p3", "textarea", rows=4),
    hint("founder", "Карточка основателя: квадратное фото, цитата и подпись."),
    a("founder_photo", "Фото основателя", "about_founder_photo", "image", 34, **image),
    *[dict(f, wrapper={"width": "33", "class": "", "id": ""}) for f in twins(a, "founder_alt", "Описание фото (alt)", "about_founder_alt")],
    *twins(a, "founder_quote", "Цитата", "about_founder_quote", "textarea"),
    *twins(a, "founder_name", "Имя", "about_founder_name"),
    *twins(a, "founder_title", "Подпись под именем", "about_founder_title"),
    hint("milestones", "Хронология: ровно три вехи. Год третьей — всегда текущий, его ставит сайт."),
    repeater("milestones", "Вехи", "about_milestones", [
        ms("milestone_year", "Год", "year", "number", 16, **year),
        *twins(ms, "milestone_name", "Название", "name"),
        *twins(ms, "milestone_wit", "Подпись", "wit"),
    ], "Добавить веху", min=3, max=3, layout="table"),
    hint("counters", "Счётчик заказов: числа — только подтверждённые кухней, целые. Показываются три; если строк "
                     "больше, сайт перелистывает их по одной."),
    *twins(a, "counters_label", "Заголовок счётчика · строка 1", "about_counters_label"),
    *twins(a, "counters_label_2", "Заголовок счётчика · строка 2", "about_counters_label_2", placeholder="можно без второй строки"),
    repeater("counters", "Счётчики", "about_counters", [
        ct("counter_number", "Число", "number", "number", 20, default_value="", min=0, max="", step=1, placeholder="", prepend="", append=""),
        *twins(ct, "counter_label", "Подпись", "label"),
    ], "Добавить счётчик", min=3, layout="table"),
]

# 6. Guests — the theme shows the first eight; the newest album goes on top.
g = rep("guest_cards")
guests = [
    tab("guests", "Гости"),
    *section_header(a, "guests", "about_guests"),
    hint("guest_cards", "Карточки-ссылки на фотоальбомы ВКонтакте: сайт показывает первые восемь, новый альбом — "
                        "первой строкой. Фото квадратное; подпись — коротко, она лежит на фото."),
    repeater("guest_cards", "Альбомы", "about_guest_cards", [
        g("guest_photo", "Фото", "photo", "image", 25, **image),
        g("guest_label_ru", "Подпись", "label_ru", "text", 25, required=1, **{**text, "maxlength": 24}),
        g("guest_label_en", "Подпись (EN)", "label_en", "text", 25, **{**text, "maxlength": 24}),
        g("guest_url", "Ссылка на альбом", "url", "url", 25, **url),
        *twins(g, "guest_alt", "Описание фото (alt)", "alt"),
    ], "Добавить альбом", collapsed=f"{A}guest_label_ru"),
]

# 9. Location — the headline is shared (Bar Settings); the description is this page's.
location_tab = [
    tab("location", "Адрес"),
    hint("location", "Заголовок «В самом сердце…» общий для трёх страниц — он в «Настройках бара». Здесь — текст под ним."),
    *twins(a, "location_description", "Текст", "about_location_description", "textarea", rows=4),
]

# 11. Visit CTA
cta = [
    tab("cta", "Приглашение"),
    *twins(a, "cta_headline", "Заголовок", "about_cta_headline"),
    *twins(a, "cta_body", "Текст", "about_cta_body", "textarea", rows=3),
]

# 7. Team
m, w = rep("team_members"), rep("team_wall")
# The theme holds the EN twin of each chip (inc/about-data.php → sweet_pepper_team_chips()).
CHIPS = {"ask": "Спросите меня…", "word": "Пара слов от {имя}", "pick": "Мой выбор"}
team = [
    tab("team", "Команда"),
    *section_header(a, "team", "about_team", description=False),
    hint("team_wall", "Фотолента над карточками: общие фото по годам, слева направо. Фото 3:2 — обрезается по центру."),
    repeater("team_wall", "Фотолента", "about_team_wall", [
        w("wall_photo", "Фото", "photo", "image", 60, **image),
        w("wall_year", "Год", "year", "number", 40, **{**year, "placeholder": "2019"}),
    ], "Добавить фото", layout="table"),
    hint("team_members", "Шесть или восемь человек — сетка по четыре в ряд (на планшете по два). Порядок строк — порядок на сайте: "
                         "первыми те, кто дольше всех в команде. Ушёл человек — удалите строку. Стаж считается от года «В команде с» "
                         "сам: «· 8 лет» в этом году, «· 9 лет» в следующем. Фото квадратное."),
    repeater("team_members", "Команда", "about_team_members", [
        m("member_photo", "Фото", "photo", "image", 20, **image),
        m("member_name_ru", "Имя", "name_ru", "text", 20, required=1, **text),
        m("member_name_en", "Имя (EN)", "name_en", "text", 20, **text),
        m("member_since", "В команде с", "since", "number", 20, **{**year, "placeholder": "2018"}),
        m("member_chip", "Кнопка на карточке", "chip", "select", 20, choices=CHIPS, default_value="ask", allow_null=0, **select),
        *twins(m, "member_role", "Должность", "role", placeholder="без стажа — он добавится сам"),
        m("member_name_gen", "Имя в родительном падеже", "name_gen", "text", 50,
          instructions="Для кнопки «Пара слов от …»: от Леры, от Кости.",
          conditional_logic=[[{"field": f"{A}member_chip", "operator": "==", "value": "word"}]], **text),
        m("member_spacer", "", "", "message", 50, message="", new_lines="", esc_html=0,
          conditional_logic=[[{"field": f"{A}member_chip", "operator": "==", "value": "word"}]]),
        *twins(m, "member_message", "Реплика", "message", "textarea",
               placeholder="своими словами — пока не получены, строка остаётся заглушкой"),
    ], "Добавить человека", min=6, max=8, collapsed=f"{A}member_name_ru"),
]

# 8. Careers
p = rep("positions")
# The theme holds the EN twin of each department (inc/about-data.php → sweet_pepper_about_departments()).
DEPARTMENTS = {"service": "Зал", "kitchen": "Кухня", "bar": "Бар"}
careers = [
    tab("careers", "Вакансии"),
    *section_header(a, "careers", "about_careers"),
    hint("positions", "Одна строка — одна вакансия. Порядок строк — порядок на сайте: перетащите строку за номер слева. "
                      "«Скрыть» убирает вакансию с сайта, строка остаётся здесь. Если открытых вакансий нет — скройте или "
                      "удалите все строки: на сайте появится блок «Вакансий пока нет» (его текст — ниже)."),
    repeater("positions", "Вакансии", "about_positions", [
        p("position_department", "Отдел", "department", "select", 20, choices=DEPARTMENTS, default_value="service", allow_null=0, **select),
        p("position_title_ru", "Должность", "title_ru", "text", 30, **text),  # not required: a row with no title in either language is skipped
        p("position_title_en", "Должность (EN)", "title_en", "text", 30, **text),
        p("position_hidden", "Скрыть", "hidden", "true_false", 20, **toggle),
        *twins(p, "position_meta", "График", "meta", placeholder="Полный день · 2/2"),
        *twins(p, "position_description", "Описание", "description", "textarea"),
        p("position_url", "Ссылка на вакансию (hh.ru)", "url", "url", "", default_value="", placeholder="без ссылки карточка выходит без кнопки"),
    ], "Добавить вакансию", collapsed=f"{A}position_title_ru"),
    *twins(a, "careers_cta_title", "Под вакансиями · заголовок", "about_careers_cta_title"),
    *twins(a, "careers_cta_text", "Под вакансиями · текст", "about_careers_cta_text"),
    *twins(a, "careers_empty_title", "Вакансий нет · заголовок", "about_careers_empty_title"),
    *twins(a, "careers_empty_text", "Вакансий нет · текст", "about_careers_empty_text", "textarea"),
]

about = group(
    "group_sp_about", "О баре", hero + concept + reviews + perks + story + guests + team + careers + location_tab + cta,
    {"param": "page_template", "operator": "==", "value": "page-about.php"},
    "The About page, one tab per section. Generated by tools/page-field-groups.py; read by inc/about-data.php.")

# ── Location headline (Bar Settings) ──
L = "field_sp_location_"
l = lambda *args, **k: field(*args, prefix=L, **k)

location = group(
    "group_sp_location", "Локация — заголовок", [
        l("hint", "", "", "message",
          message="Один заголовок на три страницы: «О баре», «Меню» и «Как добраться». Всегда в две строки.",
          new_lines="", esc_html=0),
        *twins(l, "headline", "Строка 1", "location_headline"),
        *twins(l, "headline_2", "Строка 2", "location_headline_2"),
    ],
    {"param": "options_page", "operator": "==", "value": "sweet-pepper-settings"},
    "The location headline shared by About, Menu and Visit. Generated by tools/page-field-groups.py; read by inc/location.php.",
    menu_order=1)

# ── Pairings (the dish picker) ──
# Temporary shape (author, 21 Sep 2026): the dish and the drink are TYPED here — name,
# description, photo — because only Soups is in the database and the menu store is not
# decided. When the menu migrates, the dish and drink columns become dropdowns of menu
# dishes and the copied fields go (website-brief.md → Picker pairings). The reply line,
# the short label and "opens first" are the pairing's own and stay.
P = "field_sp_pair_"
pr = lambda *args, **k: field(*args, prefix=P, parent="rows", **k)
BAR_SECTIONS = {"infusions": "Настойки", "cocktails": "Коктейли", "wine": "Вино", "beer": "Пиво",
                "spirits": "Крепкое", "no-buzz": "Без градуса", "tea-coffee": "Чай и кофе"}
pairings = group(
    "group_sp_pairings", "Гастробот", [
        field("hint", "", "", "message", prefix=P, new_lines="", esc_html=0,
              message="Одна строка — одна пара «блюдо → напиток». Порядок строк — порядок ярлыков на сайте. "
                      "«Открывается первой» — пара, которую гость видит до выбора (одна на список). "
                      "«Скрыть» убирает пару, пока блюда нет в меню. Пока меню не переехало в админку, блюдо и "
                      "напиток здесь набираются руками; потом они станут выбором из меню."),
        field("rows", "Пары", "pairs", "repeater", prefix=P, layout="block", pagination=0, min=0, max=8,
              collapsed=f"{P}dish_name_ru", button_label="Добавить пару", rows_per_page=20, sub_fields=[
                  pr("dish_photo", "Фото блюда", "dish_photo", "image", 20, **image),
                  pr("dish_name_ru", "Блюдо", "dish_name_ru", "text", 20, required=1, **text),
                  pr("dish_name_en", "Блюдо (EN)", "dish_name_en", "text", 20, **text),
                  pr("default", "Открывается первой", "default", "true_false", 20, **toggle),
                  pr("hidden", "Скрыть", "hidden", "true_false", 20, **toggle),
                  *twins(pr, "dish_short", "Короткое имя на билете", "dish_short", placeholder="если полное не помещается"),
                  *twins(pr, "dish_description", "Строка о блюде", "dish_description"),
                  pr("drink_photo", "Фото напитка", "drink_photo", "image", 20, **image),
                  pr("drink_section", "Раздел бара — куда ведёт «О напитке»", "drink_section", "select", 30,
                     choices=BAR_SECTIONS, default_value="infusions", allow_null=0, **select),
                  pr("reply_spacer", "", "", "message", 50, message="", new_lines="", esc_html=0),
                  *twins(pr, "reply", "Ответ бара — что налить", "reply", placeholder="Стопка облепиховой настойки"),
              ]),
    ], "pairings",
    "The dish picker's pairings — one record for the menu page and About. Generated by tools/page-field-groups.py; read by inc/pairings.php.")

write_groups((about, location, pairings))
