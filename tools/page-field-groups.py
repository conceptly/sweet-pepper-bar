#!/usr/bin/env python3
"""Generate the page field groups in sweet-pepper-theme/acf-json/.

    python3 tools/page-field-groups.py

  group_sp_about.json    — the About page's fields: one tab per section, on Page Template = About
                           (a tab per section, all eleven sections since 21 Sep 2026)
  group_sp_visit.json    — the Visit page's fields: one tab per section (24 Sep 2026), on
                           Page Template = Visit
  group_sp_location.json — the location headline every page shares, on Bar Settings
  group_sp_pairings.json — the dish picker's rows, on the one `pairings` record
  group_sp_menu_food.json — the kitchen menu page: a tab per section (words, photos, subsections → dish
                           lists), «Сезонное меню», the door to the bar, «Поиск» (Page Template = Menu)
  group_sp_menu_bar.json — the same for the bar page (Page Template = Menu — Bar), drink lists
  group_sp_menu_index.json — a note on the «Меню» folder page (Page Template = Menu — Index)
  group_sp_home.json     — the home page: a tab per section (hero dayparts + closed hours, highlights,
                           the two previews, about, events, contacts, «Поиск») on the front page

Sections are added as they leave the templates (website-brief.md → Content editing →
About fields): lists first, prose after. A tab exists only once its template reads it —
a field is a promise.

Every text has an `_ru` / `_en` twin, RU on the left; the theme prints one language per
request and borrows the other for a twin left empty (inc/fields.php). Field names are read
by sweet-pepper-theme/inc/about-data.php, inc/visit-data.php, inc/location.php, inc/menu-page.php, inc/home-data.php and tools/page-seed.php.
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

# ── Visit ── one tab per section, in page order (author, 24 Sep 2026: the About shape).
# Read by inc/visit-data.php as visit_<section>_<key>; typed fallback and seed source
# data/visit/<section>.php. Not here on purpose: the phone, the accounts and the email
# address (facts, not confirmed for publishing), the route maps and map links (structure),
# the phone booking block and the form (deferred by visit-page-copy-ru-draft.md), the
# connectors (structure — template-parts/visit/connector.php).
V = "field_sp_visit_"
v = lambda *args, **k: field(*args, prefix=V, **k)
vtab = lambda key, label: v(f"{key}_tab", label, "", "tab", placement="top", endpoint=0)
vhint = lambda key, message: v(f"{key}_hint", "", "", "message", message=message, new_lines="", esc_html=0)
vt = lambda section, key, label, type_="text", **k: twins(v, f"{section}_{key}", label, f"visit_{section}_{key}", type_, **k)

visit_hero = [
    vtab("hero", "Первый экран"),
    *vt("hero", "eyebrow", "Надзаголовок"),
    *vt("hero", "headline", "Заголовок"),
    *vt("hero", "description", "Текст", "textarea", rows=3),
]

visit_status = [
    vtab("status", "Статус бара"),
    vhint("status", "Полоса под первым экраном. Сайт сам выбирает состояние по часам работы бара (они в «Настройках бара»); "
                    "здесь — только слова для каждого состояния. <strong>Вводная строка</strong> видна только на компьютере; "
                    "на телефоне бегут одни состояния бара и кухни."),
    *vt("status", "lead_open", "Вводная строка · бар и кухня открыты"),
    *vt("status", "lead_last_orders", "Вводная строка · кухня принимает последние заказы"),
    *vt("status", "lead_bar_snacks", "Вводная строка · только закуски, бар работает"),
    *vt("status", "lead_winding", "Вводная строка · бар заканчивает работу"),
    *vt("status", "lead_closed", "Вводная строка · закрыто"),
    *vt("status", "bar_open", "Бар · открыт"),
    *vt("status", "bar_wrapping", "Бар · заканчивает работу"),
    *vt("status", "bar_closed", "Бар · закрыт"),
    *vt("status", "kitchen_open", "Кухня · открыта"),
    *vt("status", "kitchen_last_orders", "Кухня · последние заказы"),
    *vt("status", "kitchen_bar_snacks", "Кухня · только закуски"),
    *vt("status", "kitchen_closed", "Кухня · закрыта"),
]

visit_hours = [
    vtab("hours", "Часы и новости"),
    vhint("hours", "Карточка с часами. Сами часы и исключения — в «Настройках бара», здесь только заголовки и блок соцсетей "
                   "под ними. Ссылка ведёт во ВКонтакте (на английской версии — в Instagram)."),
    *vt("hours", "hours_title", "Заголовок часов"),
    *vt("hours", "social_title", "Заголовок блока соцсетей"),
    *vt("hours", "social_text", "Текст блока соцсетей"),
    *vt("hours", "social_link", "Текст ссылки"),
]

visit_contacts = [
    vtab("contacts", "Контакты"),
    vhint("contacts", "Карточка «На связи»: заголовки и строки-пояснения под каждым контактом. Сами номер, аккаунты и почта "
                      "пока в коде — их впишут сюда, когда они будут подтверждены для публикации."),
    *vt("contacts", "title", "Заголовок карточки"),
    *vt("contacts", "book_heading", "Телефон и соцсети · заголовок"),
    *vt("contacts", "phone_note", "Под телефоном"),
    *vt("contacts", "vk_note", "Под ВКонтакте"),
    *vt("contacts", "ig_note", "Под Instagram"),
    *vt("contacts", "email_heading", "Почта · заголовок"),
    *vt("contacts", "email_note", "Под почтой"),
    *vt("contacts", "place_heading", "Адрес · заголовок"),
    *vt("contacts", "address", "Адрес"),
    *vt("contacts", "address_note", "Под адресом"),
]

# The six landmark badges are fixed slots: each has its own route map in the template, so
# they are one group field per slot, not a list that could be reordered away from its map.
LANDMARKS = [("door", "Вход"), ("tower", "Знаменская башня"), ("square", "Советская площадь"),
             ("strelka", "Стрелка"), ("kremlin", "Богоявленская площадь"), ("stop", "Ближайшая остановка")]
def landmark(slot, title):
    s = lambda key, label, width: field(f"landmark_{slot}_{key}", label, key, "text", width, prefix=V, **text)
    return v(f"landmark_{slot}", title, f"visit_landmark_{slot}", "group", layout="table", sub_fields=[
        s("name_ru", "Название", 17), s("name_en", "Название (EN)", 17),
        s("hint_ru", "Пояснение", 17), s("hint_en", "Пояснение (EN)", 17),
        s("distance_ru", "Расстояние и время", 16), s("distance_en", "Расстояние и время (EN)", 16),
    ])

visit_location = [
    vtab("location", "Как добраться"),
    vhint("location", "Заголовок «В самом сердце…» общий для трёх страниц — он в «Настройках бара». Здесь — надзаголовок, "
                      "заметка «Полезно знать» и шесть ориентиров слева от карты."),
    *vt("location", "eyebrow", "Надзаголовок"),
    *vt("location", "note_title", "Заметка · заголовок"),
    *vt("location", "note_main", "Заметка · главная строка"),
    *vt("location", "note_sub", "Заметка · пояснение"),
    vhint("landmarks", "Ориентиры: у каждого своя карта с пешим маршрутом, поэтому их ровно шесть и порядок не меняется. "
                       "Расстояние пишите так: «350 м · 5 мин». У входа расстояния нет."),
    *[landmark(slot, title) for slot, title in LANDMARKS],
]

visit_cta = [
    vtab("cta", "Обратная связь"),
    vhint("cta", "Текст слева от формы и фото входа (на телефоне фото идёт широкой полосой над разделом). Сама форма и блок "
                 "бронирования на телефоне пока в коде."),
    *vt("cta", "headline", "Заголовок"),
    *vt("cta", "body", "Текст", "textarea", rows=3),
    v("cta_photo", "Фото входа", "visit_cta_photo", "image", 34, instructions="Горизонтальное, 3:2 — обрезается по центру.", **image),
    *[dict(f, wrapper={"width": "33", "class": "", "id": ""}) for f in vt("cta", "alt", "Описание фото для скринридера")],
]

visit = group(
    "group_sp_visit", "Как добраться", visit_hero + visit_status + visit_hours + visit_contacts + visit_location + visit_cta,
    {"param": "page_template", "operator": "==", "value": "page-visit.php"},
    "The Visit page, one tab per section. Generated by tools/page-field-groups.py; read by inc/visit-data.php.")

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

# ── The menu pages ── «Меню — кухня» (page-menu.php) and «Меню — бар» (page-menu-bar.php).
# One group per page, the About shape: a tab per SECTION (author, 24 Sep 2026: "the same way
# we did it for the About page, section by section") holding everything section-level — the
# nav words, the hero photo + caption + paragraph, the section photo + its vertical position,
# headline, eyebrow, the deal card, and the subsections → ordered Relationship lists of dishes
# (kitchen) or drinks (bar); then «Сезонное меню», the door to the other menu, «Поиск».
# Read by inc/menu-sections.php, inc/menu-data-dishes.php, inc/menu-page.php; typed fallback
# inc/menu-sections.php + data/menu/sections-copy.php + data/menu/page.php; seeded by
# tools/page-seed.php menu (words, photos, lists migrated from the retired «Разделы меню»)
# and tools/menu-seed.php (dish posts + lists from data/menu/<slug>.php).
# A dish itself is never here: it is picked (group_sp_dish.json, tools/menu-field-group.py).
SECTIONS = {
    "food":   [("breakfast", "Завтраки"), ("lunch", "Обеды"), ("bar-snacks", "Закуски"), ("salads", "Салаты"),
               ("sandwiches", "Сэндвичи"), ("soups", "Супы"), ("hot-dishes", "Горячее"), ("desserts", "Десерты"), ("kids", "Детям")],
    "drinks": [("infusions", "Настойки"), ("cocktails", "Коктейли"), ("wine", "Вино"), ("beer", "Пиво"),
               ("spirits", "Крепкое"), ("no-buzz", "Без алкоголя"), ("tea-coffee", "Чай и кофе")],
}
# A range can never be empty: the form shows 0 for an unsaved value and would store it on the first
# Update — so the default is the centre, which is what the site shows while nothing is set.
slider = dict(default_value=50, min=0, max=100, step=5, prepend="", append="%")

def section_tab(f, slug, title, prefix, item_type):
    """One section's tab. Field names: sec_<slug with _>_<key>[_<lang>] — read by
    inc/menu-sections.php (words, photos) and inc/menu-data-dishes.php (subsections)."""
    n = "sec_" + slug.replace("-", "_") + "_"
    r = lambda *args, **k: field(*args, prefix=prefix, parent=f"{n}subsections", **k)
    return [
        f(f"{n}tab", title, "", "tab", placement="top", endpoint=0),
        f(f"{n}hint", "", "", "message", new_lines="", esc_html=0,
          message="Слова раздела, его фото и список блюд. Само блюдо (цена, выход, описание) правится в «Блюдах» / «Напитках»; "
                  "здесь оно только выбирается и ставится на место."),
        *twins(f, f"{n}label", "Название в навигации", f"{n}label", placeholder="коротко: список разделов и строка на телефоне"),
        *twins(f, f"{n}cta_label", "Кнопка на первом экране (телефон)", f"{n}cta_label"),
        *twins(f, f"{n}headline", "Заголовок раздела", f"{n}headline", placeholder="пусто — как название в навигации"),
        *twins(f, f"{n}eyebrow", "Надзаголовок", f"{n}eyebrow"),
        f(f"{n}hero_hint", "", "", "message", new_lines="", esc_html=0,
          message="<strong>Первый экран</strong> — фото, его подпись и абзац, которые показываются, когда гость выбирает этот раздел в списке."),
        # Widths leave the previews room (inc/admin-photo-preview.php draws the site's crop in the field).
        f(f"{n}hero_photo", "Фото на первом экране", f"{n}hero_photo", "image", 50, instructions="Горизонтальное, 3:2.", **image),
        f(f"{n}hero_focus", "Что оставить в кадре на планшете", f"{n}hero_focus", "range", 50,
          instructions="Планшет обрезает фото сверху и снизу: 0 — верх, 100 — низ. Рамка на фото слева показывает кадр.", **slider),
        *twins(f, f"{n}caption", "Подпись фото", f"{n}caption", placeholder="что на фото"),
        *twins(f, f"{n}description", "Абзац на первом экране", f"{n}description", "textarea", rows=3),
        f(f"{n}band_hint", "", "", "message", new_lines="", esc_html=0,
          message="<strong>Фото раздела</strong> — широкая полоса над списком блюд."),
        f(f"{n}photo", "Фото раздела", f"{n}photo", "image", 67, instructions="Горизонтальное; на сайте — полоса 4:1, как в окне слева.", **image),
        f(f"{n}photo_y", "Вертикальное положение", f"{n}photo_y", "range", 33,
          instructions="Какую часть фото оставить в полосе: 0 — верх, 100 — низ. Окно слева двигается вместе с ползунком.", **slider),
        *twins(f, f"{n}pill", "Подпись фото раздела", f"{n}pill", placeholder="что на фото"),
        *twins(f, f"{n}alt", "Описание фото для скринридера", f"{n}alt", placeholder="пусто — как подпись"),
        f(f"{n}deal_hint", "", "", "message", new_lines="", esc_html=0,
          message="<strong>Акция</strong> — карточка справа от заголовка. Без заголовка акции карточки нет."),
        *twins(f, f"{n}deal_title", "Акция: заголовок", f"{n}deal_title"),
        *twins(f, f"{n}deal_main", "Акция: главная строка", f"{n}deal_main"),
        *twins(f, f"{n}deal_sub", "Акция: вторая строка", f"{n}deal_sub"),
        *twins(f, f"{n}deal_link", "Акция: ссылка вместо второй строки", f"{n}deal_link", placeholder="ведёт в барное меню"),
        f(f"{n}list_hint", "", "", "message", new_lines="", esc_html=0,
          message="<strong>Блюда раздела</strong> по подразделам. Порядок — порядок на сайте: подразделы перетаскиваются за номер, "
                  "блюда — в правой колонке списка. Блюдо в черновике на сайте не показывается, но остаётся в списке."),
        f(f"{n}subsections", "Подразделы и блюда", f"{n}subsections", "repeater", layout="block", pagination=0, min=0, max=0,
          collapsed=f"{prefix}{n}sub_title_ru", button_label="Добавить подраздел", rows_per_page=20, sub_fields=[
              r(f"{n}sub_title_ru", "Подраздел", "title_ru", "text", 35, **{**text, "placeholder": "можно без заголовка"}),
              r(f"{n}sub_title_en", "Подраздел (EN)", "title_en", "text", 35, **text),
              r(f"{n}sub_column", "Колонка", "column", "select", 15,
                choices={"left": "Левая", "right": "Правая"}, default_value="left", allow_null=0, **select),
              r(f"{n}sub_style", "Вид", "style", "select", 15,
                choices={"list": "Список", "card": "Карточка (добавки, соусы)"}, default_value="list", allow_null=0, **select),
              r(f"{n}sub_dishes", "Блюда" if item_type == "dish" else "Напитки", "dishes", "relationship", "",
                post_type=[item_type], post_status=["publish", "draft"], taxonomy=[], filters=["search"],
                return_format="id", min="", max="", elements=["featured_image"], bidirectional=0, bidirectional_target=[]),
              r(f"{n}sub_note_ru", "Примечание под подразделом", "note_ru", "text", 40, **text),
              r(f"{n}sub_note_en", "Примечание (EN)", "note_en", "text", 40, **text),
              r(f"{n}sub_divider", "Черта перед подразделом", "divider", "true_false", 20, **{**toggle, "message": "Новый блок колонок"}),
          ]),
    ]

def menu_page_group(state, key, title, template, prefix, item_type, door_tab, door_hint):
    mp = lambda *args, **k: field(*args, prefix=prefix, **k)
    mtab = lambda k, label: mp(f"{k}_tab", label, "", "tab", placement="top", endpoint=0)
    mhint = lambda k, message: mp(f"{k}_hint", "", "", "message", message=message, new_lines="", esc_html=0)
    fields = []
    for slug, name in SECTIONS[state]:
        fields += section_tab(mp, slug, name, prefix, item_type)
    fields += [
        mtab("highlights", "Сезонное меню"),
        *twins(mp, "highlights_eyebrow", "Надзаголовок", "menu_highlights_eyebrow"),
        *twins(mp, "highlights_headline", "Заголовок · строка 1", "menu_highlights_headline"),
        *twins(mp, "highlights_headline_2", "Заголовок · строка 2", "menu_highlights_headline_2", placeholder="можно без второй строки"),
        mhint("highlights", "Карточки полосы после первого экрана — " + ("блюда" if item_type == "dish" else "напитки") +
              " из меню, до восьми; порядок здесь — порядок на сайте. Название, фото и ссылка на раздел берутся из записи: "
              "фото — «Фото» в карточке блюда, без него карточка показывает фото раздела. "
              "Пустой список — на сайте стоят позиции с сезонной меткой."),
        mp("highlights", "Блюда сезонного меню" if item_type == "dish" else "Напитки сезонного меню", "menu_highlights", "relationship", "",
           post_type=["dish", "drink"], post_status=["publish"], taxonomy=[], filters=["search", "post_type"],
           return_format="id", min=0, max=8, elements=["featured_image"], bidirectional=0, bidirectional_target=[]),
        mtab("door", door_tab),
        mhint("door", door_hint),
        *twins(mp, "door_label", "Слово на двери", "menu_door_label", placeholder="Напитки / Еда"),
        mp("door_photo", "Фото при наведении", "menu_door_photo", "image", 34, instructions="Горизонтальное, 3:2 — обрезается по центру.", **image),
        *[dict(f, wrapper={"width": "33", "class": "", "id": ""}) for f in twins(mp, "door_caption", "Подпись фото", "menu_door_caption", placeholder="что на фото")],
        *twins(mp, "door_description", "Абзац о другом меню", "menu_door_description", "textarea", rows=3),
        # The kitchen page has a day and a night theme; the bar page is always dark.
        *([
            mhint("door_night", "<strong>Ночью</strong> — когда сайт в ночной теме (вечером и в тёмное время), дверь показывает другое фото: "
                                "например, коктейли вместо кофе. Слово на двери то же. Пусто — ночью то же, что днём."),
            mp("door_night_photo", "Фото при наведении — ночью", "menu_door_night_photo", "image", 34, instructions="Горизонтальное, 3:2.", **image),
            *[dict(f, wrapper={"width": "33", "class": "", "id": ""}) for f in twins(mp, "door_night_caption", "Подпись фото — ночью", "menu_door_night_caption", placeholder="что на фото")],
            *twins(mp, "door_night_description", "Абзац о баре — ночью", "menu_door_night_description", "textarea", rows=3, placeholder="пусто — как днём"),
        ] if state == "food" else []),
        mtab("seo", "Поиск"),
        mhint("seo", "Название вкладки браузера и строка, которую показывает поиск. Имя сайта добавляется само."),
        *twins(mp, "seo_title", "Название страницы", "menu_seo_title", placeholder="Меню кухни / Барное меню"),
        *twins(mp, "seo_description", "Описание для поиска", "menu_seo_description", "textarea", rows=3, maxlength=160),
    ]
    return group(key, title, fields, {"param": "page_template", "operator": "==", "value": template},
                 f"The {state} menu page: a tab per section (words, photos, subsections → lists of {item_type} posts), "
                 "«Сезонное меню», the door, «Поиск». Generated by tools/page-field-groups.py; read by inc/menu-sections.php, "
                 "inc/menu-data-dishes.php, inc/menu-page.php.")

menu_food = menu_page_group("food", "group_sp_menu_food", "Меню — кухня", "page-menu.php", "field_sp_mfood_", "dish",
                            "Дверь в бар", "Блок со стрелкой под списком разделов, ведёт в барное меню: слово на двери, "
                                           "а при наведении — фото, его подпись и абзац о баре.")
menu_bar = menu_page_group("drinks", "group_sp_menu_bar", "Меню — бар", "page-menu-bar.php", "field_sp_mbar_", "drink",
                           "Дверь на кухню", "Блок со стрелкой под списком разделов, ведёт в меню кухни: слово на двери, "
                                             "а при наведении — фото, его подпись и абзац о кухне.")

# The «Меню» folder page (/menu/, page-menu-index.php): nothing to edit, so its screen says why.
M = "field_sp_mpage_"
mp = lambda *args, **k: field(*args, prefix=M, **k)
menu_index = group(
    "group_sp_menu_index", "Меню — папка", [
        mp("index_hint", "", "", "message", new_lines="", esc_html=0,
           message="У этой страницы нет своих текстов: она — папка для двух меню, а адрес /menu/ ведёт на кухню (/menu/food/). "
                   "Разделы, сезонное меню и название страницы — на страницах «Меню — кухня» и «Меню — бар» ниже в списке."),
    ],
    {"param": "page_template", "operator": "==", "value": "page-menu-index.php"},
    "The menu folder page holds nothing; this says so. Generated by tools/page-field-groups.py.")

# ── The Home page ── the front page (Settings → Reading → a static page; tools/page-seed.php home
# makes «Главная» and sets it). One group, the About shape: a tab per section in page order —
# «Первый экран» (the four dayparts' words and tile photos, the closed-hours lines), «Что попробовать»
# (header + three cards that point at menu dishes), «Настойки» / «Обед» (the two previews: title,
# photo, three menu rows), «О баре», «Что нового» (header + the social cards), «Визит и связь», «Поиск».
# Located on the FRONT PAGE, whichever page that is. Read by inc/home-data.php; typed fallback and
# seed source data/home/<section>.php. Structure stays in code: the tile order, the connectors,
# the daypart engine, the menu button's destination, the map, the contact channels.
H = "field_sp_home_"
h = lambda *args, **k: field(*args, prefix=H, **k)
hrep = lambda parent: (lambda *args, **k: field(*args, prefix=H, parent=parent, **k))
htab = lambda key, label: h(f"{key}_tab", label, "", "tab", placement="top", endpoint=0)
hhint = lambda key, message: h(f"{key}_hint", "", "", "message", message=message, new_lines="", esc_html=0)
photo_row = lambda key, label, name, note: [
    # a photo at 34 and its alt twins at 33 + 33 — the About founder's row
    h(f"{key}_photo", label, f"{name}_photo", "image", 34, instructions=note, **image),
    *[dict(f, wrapper={"width": "33", "class": "", "id": ""}) for f in twins(h, f"{key}_alt", "Описание фото (alt)", f"{name}_alt")],
]
ALL_SECTIONS = {slug: name for state in SECTIONS.values() for slug, name in state}
DAYPARTS = [("breakfast", "Завтрак"), ("lunch", "Обед"), ("dinner", "Ужин"), ("party", "Вечер")]

# 1. Hero — the daypart engine keeps the clock, the theme and the button's destination.
hero_home = [
    htab("hero", "Первый экран"),
    hhint("hero", "Четыре набора — по времени суток: гость видит тот, что сейчас на часах бара, и может выбрать другой "
                  "плиткой. Заголовок в одну строку, капслок ставит сайт."),
    *twins(h, "hero_eyebrow", "Надзаголовок", "home_hero_eyebrow"),
]
for dp, name in DAYPARTS:
    hero_home += [
        hhint(f"hero_{dp}", f"<strong>{name}</strong>"),
        *photo_row(f"hero_{dp}", "Фото плитки", f"home_hero_{dp}", "Горизонтальное, 3:2 — плитка показывает его квадратом, выбранная — целиком."),
        *twins(h, f"hero_{dp}_headline", "Заголовок", f"home_hero_{dp}_headline"),
        *twins(h, f"hero_{dp}_body", "Текст", f"home_hero_{dp}_body", "textarea"),
        *twins(h, f"hero_{dp}_button", "Кнопка меню", f"home_hero_{dp}_button", placeholder="ведёт в свой раздел меню"),
    ]
hero_home += [
    hhint("hero_closed", "<strong>Когда бар закрыт</strong> — плитка остаётся подсвеченной, а слова другие; слова «закрыто» на первом "
                         "экране нет. «{time}» в тексте — время открытия, сайт подставляет его сам из «Настроек бара»."),
]
for window, name in [("night", "Ночь — после закрытия до 4:00"), ("morning", "Утро — с 4:00 до открытия"), ("sunday", "Воскресное утро — до 10:00")]:
    hero_home += [
        hhint(f"hero_closed_{window}", f"<strong>{name}</strong>"),
        *twins(h, f"hero_closed_{window}_headline", "Заголовок", f"home_hero_closed_{window}_headline"),
        *twins(h, f"hero_closed_{window}_body", "Текст", f"home_hero_closed_{window}_body", placeholder="… с {time}."),
    ]

# 2. Highlights — three cards. A card points at a menu dish (name, price, description and photo from its
# record; the link to its section), or — the House infusions card — is a category typed by hand.
TAG_ICONS = {"": "— без метки", "star": "Звезда", "fire": "Огонь — хит", "Pepper": "Перец — острое", "veg": "Лист — вегетарианское", "yaroslavl-logo": "Ярославль — местное"}
no_dish = [[{"field": f"{H}card_dish", "operator": "==empty"}]]
hc = hrep("highlight_cards")
highlights_home = [
    htab("highlights", "Что попробовать"),
    *section_header(h, "highlights", "home_highlights"),
    hhint("highlight_cards", "Ровно три карточки, порядок строк — порядок на сайте. Обычно карточка — блюдо или напиток из меню: "
                             "название, цена и фото берутся из его записи, ссылка ведёт в его раздел; название и описание на карточке "
                             "можно задать свои. Карточка без блюда — категория (например, настойки): её слова и фото набираются здесь."),
    h("highlight_cards", "Карточки", "home_highlight_cards", "repeater", layout="block", pagination=0, min=3, max=3,
      collapsed=f"{H}card_title_ru", button_label="Добавить карточку", rows_per_page=20, sub_fields=[
          hc("card_dish", "Блюдо или напиток из меню", "dish", "relationship", 50,
             post_type=["dish", "drink"], post_status=["publish"], taxonomy=[], filters=["search", "post_type"],
             return_format="id", min=0, max=1, elements=["featured_image"], bidirectional=0, bidirectional_target=[]),
          hc("card_title_ru", "Название на карточке", "title_ru", "text", 25, **{**text, "placeholder": "пусто — как в меню"}),
          hc("card_title_en", "Название на карточке (EN)", "title_en", "text", 25, **{**text, "placeholder": "если в меню длиннее"}),
          hc("card_photo", "Фото", "photo", "image", 34, instructions="Горизонтальное, 3:2.", conditional_logic=no_dish, **image),
          hc("card_section", "Куда ведёт карточка", "section", "select", 66, choices=ALL_SECTIONS, default_value="infusions",
             allow_null=0, conditional_logic=no_dish, **select),
          # "From 150 ₽" / «От 150 ₽» — a word in it, so a twin
          *[dict(f, conditional_logic=no_dish) for f in twins(hc, "card_price", "Цена", "price", placeholder="От 150 ₽")],
          *twins(hc, "card_description", "Описание на карточке", "description", "textarea", placeholder="пусто — как в меню"),
          hc("card_tag_icon", "Метка: значок", "tag_icon", "select", 34, choices=TAG_ICONS, default_value="", allow_null=0, **select),
          *[dict(f, wrapper={"width": "33", "class": "", "id": ""}) for f in twins(hc, "card_tag_label", "Метка: слово", "tag_label", placeholder="Сезонный хит")],
      ]),
]

def preview_tab(key, title, name, item_type, item_label):
    """A menu preview: title, the photo with its caption, three rows that point at menu items."""
    return [
        htab(key, title),
        hhint(key, "Заголовок, фото и три строки из меню. Название, выход, цена и описание — из записи блюда; порядок — порядок на сайте."),
        *twins(h, f"{key}_title", "Заголовок", f"{name}_title"),
        *photo_row(key, "Фото", name, "Горизонтальное, 3:2."),
        *twins(h, f"{key}_badge", "Подпись на фото", f"{name}_badge", placeholder="пусто — без подписи"),
        h(f"{key}_items", item_label, f"{name}_items", "relationship", "",
          post_type=[item_type], post_status=["publish"], taxonomy=[], filters=["search"],
          return_format="id", min=0, max=3, elements=["featured_image"], bidirectional=0, bidirectional_target=[]),
    ]

bar_home     = preview_tab("bar", "Настойки", "home_bar", "drink", "Напитки")
kitchen_home = preview_tab("kitchen", "Обед", "home_kitchen", "dish", "Блюда")

# 5. About preview — the years are counted by the site from the founding year (the team tenure's rule).
about_home = [
    htab("about", "О баре"),
    *section_header(h, "about", "home_about"),
    *photo_row("about", "Фото", "home_about", "Горизонтальное, 3:2."),
    h("about_since", "Год основания", "home_about_since", "number", 34,
      instructions="Сайт считает «12 лет» сам: в этом году 12, в следующем 13.", **{**year, "placeholder": "2014"}),
    *[dict(f, wrapper={"width": "33", "class": "", "id": ""}) for f in twins(h, "about_rating", "Рейтинг", "home_about_rating", placeholder="5.0 на Яндекс Картах")],
]

# 6. Events — the social entrance: header, up to five cards, the «Ещё во ВКонтакте» tile.
ec = hrep("event_cards")
events_home = [
    htab("events", "Что нового"),
    *section_header(h, "events", "home_events"),
    hhint("event_cards", "<strong>Карточки английской страницы</strong> (/en/). На русской главной карточки приходят из ВКонтакте сами — "
                         "«Посты ВКонтакте» в меню слева. До пяти карточек, порядок строк — порядок на сайте. Фото вертикальное 4:5. "
                         "Дата — необязательна: сегодняшняя показывается как «Today!». «Закрепить» выделяет карточку рамкой."),
    h("event_cards", "Карточки (EN)", "home_event_cards", "repeater", layout="block", pagination=0, min=0, max=5,
      collapsed=f"{H}event_title_en", button_label="Добавить карточку", rows_per_page=20, sub_fields=[
          ec("event_cover", "Фото", "cover", "image", 25, instructions="Вертикальное, 4:5.", **image),
          ec("event_title_en", "Подпись (EN)", "title_en", "text", 25, required=1, **text),
          ec("event_date", "Дата", "date", "date_picker", 25, display_format="d.m.Y", return_format="Y-m-d", first_day=1),
          ec("event_category", "Метка", "category", "select", 25,
             choices={"": "— без метки", "event": "Событие", "promo": "Акция", "community": "Наши гости"}, default_value="", allow_null=0, **select),
          ec("event_source", "Где выложено", "source", "select", 25, choices={"vk": "ВКонтакте", "instagram": "Instagram"}, default_value="vk", allow_null=0, **select),
          ec("event_url", "Ссылка на пост", "url", "url", 25, **url),
          ec("event_pinned", "Закрепить", "pinned", "true_false", 25, **toggle),
          ec("event_alt_en", "Описание фото (alt, EN)", "alt_en", "text", 25, **{**text, "placeholder": "пусто — как подпись"}),
      ]),
    hhint("events_more", "<strong>Последняя плитка</strong> — ссылка на ленту: русская страница ведёт во ВКонтакте, английская — в Instagram (адреса — Настройки бара → «Контакты»)."),
    h("events_more_photo", "Фото", "home_events_more_photo", "image", 34, instructions="Вертикальное, 4:5; на сайте затемнено.", **image),
    *[dict(f, wrapper={"width": "33", "class": "", "id": ""}) for f in twins(h, "events_more_label", "Слова на плитке", "home_events_more_label")],
]

# 7. Contacts — the words; the channels (phone, VK, Instagram, the address, the map) are the theme's until Bar Settings holds them.
contacts_home = [
    htab("contacts", "Визит и связь"),
    hhint("contacts", "Слова раздела. Телефон, адрес, ссылки на соцсети и карта — в коде сайта, до переезда в «Настройки бара»."),
    *section_header(h, "contacts", "home_contacts"),
    *twins(h, "contacts_description_mobile", "Текст на телефоне", "home_contacts_description_mobile", "textarea", placeholder="короче: на телефоне вместо текста выше"),
    *twins(h, "contacts_map_title", "Заголовок над картой", "home_contacts_map_title"),
    hhint("contacts_more", "<strong>Переход на страницу «Как добраться»</strong> — только на телефоне."),
    *twins(h, "contacts_more_title", "Заголовок", "home_contacts_more_title"),
    *twins(h, "contacts_more_text", "Текст", "home_contacts_more_text"),
]

# 8. Search — the browser tab and the description search engines show.
seo_home = [
    htab("seo", "Поиск"),
    hhint("seo", "Название вкладки браузера и строка, которую показывает поиск. Имя сайта добавляется само."),
    *twins(h, "seo_title", "Название страницы", "home_seo_title", placeholder="Бар и кухня в Ярославле"),
    *twins(h, "seo_description", "Описание для поиска", "home_seo_description", "textarea", rows=3, maxlength=160),
]

home = group(
    "group_sp_home", "Главная",
    hero_home + highlights_home + bar_home + kitchen_home + about_home + events_home + contacts_home + seo_home,
    {"param": "page_type", "operator": "==", "value": "front_page"},
    "The home page, one tab per section, on the front page. Generated by tools/page-field-groups.py; read by inc/home-data.php.")

# ── «Посты ВКонтакте» ── one record per imported post (inc/vk-feed.php). The caption is the
# post title, the cover its featured image, the link and date the importer's meta; the team's
# two knobs are here.
N = "field_sp_news_"
n = lambda *args, **k: field(*args, prefix=N, **k)
news = group(
    "group_sp_news", "ВКонтакте",
    [
        n("hint", "", "", "message", new_lines="", esc_html=0,
          message="Карточка пришла из ВКонтакте сама: фото, подпись и дата — из поста, ссылка ведёт на него. Фото и дату сайт "
                  "обновляет вслед за постом. Подпись выше можно переписать — импорт её больше не тронет; пост, снятый со стены, "
                  "уходит в черновики сам."),
        n("hidden", "Скрыть с сайта", "news_hidden", "true_false", 50,
          instructions="Запись остаётся здесь, но не показывается на главной; следующая по дате занимает её место.", **toggle),
        n("alt", "Описание фото (alt)", "news_alt", "text", 50, **{**text, "placeholder": "пусто — как подпись"}),
    ],
    "news",
    "One post imported from VK: hide it, describe its photo. Generated by tools/page-field-groups.py; read by inc/vk-feed.php.")

# ── Bar contacts (Bar Settings) ── the channels every page prints, and the people who answer
# for the vacancies. Read by inc/contacts.php; first consumer the vacancy page (25 Sep 2026) —
# the Visit card, the home Contacts and the footer still type the same values and move here next.
C = "field_sp_contacts_"
c = lambda *args, **k: field(*args, prefix=C, **k)
ch = lambda *args, **k: field(*args, prefix=C, parent="hiring", **k)
contacts = group(
    "group_sp_contacts", "Контакты", [
        c("hint", "", "", "message", new_lines="", esc_html=0,
          message="Контакты бара — одни на весь сайт. Пока их читает страница вакансии; страница «Как добраться», "
                  "главная и подвал перейдут на них следующим шагом. Пустое поле — контакт не показывается."),
        c("phone", "Телефон", "contacts_phone", "text", 34, **{**text, "placeholder": "+7 (4852) 911-202"}),
        c("email", "Почта", "contacts_email", "email", 33, default_value="", placeholder="hello@sweetpepper.bar", prepend="", append=""),
        c("telegram", "Telegram", "contacts_telegram", "text", 33, **{**text, "placeholder": "@sweetpepperbar или ссылка"}),
        c("vk", "ВКонтакте", "contacts_vk", "url", 50, default_value="", placeholder="https://vk.com/sweetpepperbar"),
        c("instagram", "Instagram", "contacts_instagram", "url", 50, default_value="", placeholder="https://instagram.com/barsweetpepper"),
        c("hiring_hint", "", "", "message", new_lines="", esc_html=0,
          message="Кто отвечает за вакансии. В каждой вакансии выбирается один человек из этого списка — или «Бар», тогда "
                  "на странице вакансии стоят контакты бара сверху. Телефон вводится один раз здесь и меняется во всех "
                  "вакансиях сразу. Удалённый человек — его вакансии возвращаются к контактам бара."),
        c("hiring", "Кто отвечает за вакансии", "hiring_contacts", "repeater", "", layout="block", pagination=0, min=0, max=0,
          collapsed=f"{C}hiring_name_ru", button_label="Добавить человека", rows_per_page=20, sub_fields=[
            hidden_id(ch, "hiring_id", "id"),
            ch("hiring_name_ru", "Имя", "name_ru", "text", 25, **text),
            ch("hiring_name_en", "Имя (EN)", "name_en", "text", 25, **text),
            ch("hiring_role_ru", "Кто это", "role_ru", "text", 25, **{**text, "placeholder": "шеф · бар-менеджер"}),
            ch("hiring_role_en", "Кто это (EN)", "role_en", "text", 25, **{**text, "placeholder": "chef · bar manager"}),
            ch("hiring_phone", "Телефон", "phone", "text", 34, **{**text, "placeholder": "+7 900 000-00-00"}),
            ch("hiring_telegram", "Telegram", "telegram", "text", 33, **{**text, "placeholder": "@имя или ссылка"}),
            ch("hiring_email", "Почта", "email", "email", 33, default_value="", placeholder="", prepend="", append=""),
        ]),
    ],
    {"param": "options_page", "operator": "==", "value": "sweet-pepper-settings"},
    "The bar's contact channels and the people who answer for vacancies. Generated by tools/page-field-groups.py; read by inc/contacts.php.",
    menu_order=2)

# ── Vacancy ── one record per opening (inc/vacancies.php). The title of the record is the Russian
# name of the role; every other text is an RU / EN twin. «На сайте» is the one control that posts,
# closes and republishes: a term counts from the save; «В архиве» closes; picking a term on an
# archived record opens it again. The end date is written by the theme (inc/vacancies.php).
J = "field_sp_vacancy_"
j = lambda *args, **k: field(*args, prefix=J, **k)
jt = lambda key, label, name, type_="text", **k: twins(j, key, label, f"vacancy_{name}", type_, **k)
SHOW = {"archive": "В архиве", "1": "1 неделя", "2": "2 недели", "4": "4 недели"}
vacancy = group(
    "group_sp_vacancy", "Вакансия", [
        j("hint", "", "", "message", new_lines="", esc_html=0,
          message="Заголовок записи — должность по-русски («Менеджер зала»). Срок «На сайте» считается с сохранения; "
                  "по его концу вакансия сама уходит в архив и пропадает со страницы «О баре» — ссылка на неё остаётся "
                  "рабочей и показывает «вакансия закрыта». Чтобы открыть заново — выберите срок и нажмите «Обновить». "
                  "Смена срока у открытой вакансии считает его заново с сегодня."),
        j("title_en", "Должность (EN)", "vacancy_title_en", "text", 40, **text),
        j("department", "Отдел", "vacancy_department", "select", 20, choices=DEPARTMENTS, default_value="service", allow_null=0, **select),
        j("show", "На сайте", "vacancy_show", "select", 20, choices=SHOW, default_value="2", allow_null=0, **select),
        j("hh", "Ссылка на hh.ru", "vacancy_hh", "url", 20, default_value="", placeholder="если вакансия есть и там"),
        *jt("schedule", "График", "schedule", placeholder="Полный день · 2/2"),
        *jt("pay", "Оплата", "pay", placeholder="от 45 000 ₽ — можно не указывать"),
        *jt("card", "Коротко · на карточке", "card", "textarea", rows=2,
            instructions="Одна-две строки на карточке вакансии — на странице «О баре» и под другими вакансиями."),
        *jt("lead", "Вступление", "lead", "textarea", rows=3, instructions="Абзац в начале страницы вакансии."),
        *jt("duties", "Что делать", "duties", "textarea", rows=5, instructions="Каждый пункт с новой строки. Пустое поле — раздела нет."),
        *jt("requirements", "Кого ищем", "requirements", "textarea", rows=5, instructions="Каждый пункт с новой строки."),
        *jt("offer", "Что предлагаем", "offer", "textarea", rows=5, instructions="Каждый пункт с новой строки."),
        j("contact", "Контакт", "vacancy_contact", "select", 50, choices={"bar": "Бар — контакты как на странице «Как добраться»"},
          default_value="bar", allow_null=0, instructions="Люди в списке — «Настройки бара» → «Контакты». Контакты бара остаются "
          "на странице второй строкой.", **select),
    ],
    "vacancy",
    "One job opening: the role, its texts in two languages, who answers, how long it shows. Generated by tools/page-field-groups.py; read by inc/vacancies.php.")

write_groups((about, visit, location, pairings, menu_food, menu_bar, menu_index, home, news, contacts, vacancy))
