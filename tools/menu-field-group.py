#!/usr/bin/env python3
"""Generate the menu field groups in sweet-pepper-theme/acf-json/.

The menu field groups are generated, not clicked (website-brief.md →
Content editing: "Field groups are generated"). Edit the fields here and re-run:

    python3 tools/menu-field-group.py

The menu store (website-brief.md → Menu storage, decided 23 Sep 2026 — option Б):
  group_sp_dish.json      — one dish or drink: on a `dish` post («Блюда») or a `drink` post («Напитки»)
  group_sp_menu_list.json — one menu section: subsections → ordered Relationship lists, on a `menu_list` record

Keys are fixed (`field_sp_dish_*`, `field_sp_list_*`), so re-running never orphans saved values.
Field names are read by sweet-pepper-theme/inc/menu-data.php, inc/menu-data-dishes.php and
tools/menu-seed.php. The losing store's group (option А, a repeater of dish rows per section)
is in git at daf35b1; website-brief.md → Menu storage → *Option А, archived* describes it.
"""
from scf_fields import field, text, area, toggle, number, select, group, write_groups

# The theme holds the EN twin of each unit (inc/menu-data.php → sweet_pepper_menu_units()).
UNITS = {"g": "г", "ml": "мл", "l": "л", "pcs": "шт"}
# Values are file names in assets/icons/. Order here = order on the page.
# Legend (author, Sep 2026): leaf = vegetarian, fire = hit, pepper = spicy, Yaroslavl logo = local dish.
ICONS = {"veg": "Лист — вегетарианское", "fire": "Огонь — хит", "Pepper": "Перец — острое", "yaroslavl-logo": "Ярославль — местное блюдо"}

def dish_fields(prefix):
    """A dish's (or a drink's) own fields, in reading order — a post has a screen to itself.
    What a post has of its own is not here: the Russian name is its title, Draft takes it off
    the site, its post ID is the stable id."""
    f = lambda *a, **k: field(*a, prefix=prefix, **k)

    name_en = f("dish_name_en", "Название (EN)", "name_en", "text", "", **text)  # full width: the RU/EN pairs below stay paired
    # Size 1, and an optional size 2 (40 мл / 500 мл → 150 / 1300).
    sizes = [
        f("dish_amount", "Выход", "amount", "number", 14, **number),
        f("dish_unit", "Ед.", "unit", "select", 14, choices=UNITS, default_value="g", allow_null=0, **select),
        f("dish_price", "Цена", "price", "number", 22, **{**number, "append": "-."}),
        f("dish_amount_2", "Выход 2", "amount_2", "number", 14, **number),
        f("dish_unit_2", "Ед.", "unit_2", "select", 14, choices=UNITS, default_value="g", allow_null=0, **select),
        f("dish_price_2", "Цена 2", "price_2", "number", 22, **{**number, "append": "-."}),
    ]
    descriptions = [
        f("dish_description_ru", "Описание", "description_ru", "textarea", 50, **area),
        f("dish_description_en", "Описание (EN)", "description_en", "textarea", 50, **area),
    ]
    more = f("dish_more", "Дополнительно: значки, сезон, опции", "", "accordion", "", open=0, multi_expand=1, endpoint=0)
    extras = [
        f("dish_icons", "Значки — не больше двух", "icons", "checkbox", 50,
          choices=ICONS, default_value=[], return_format="value", allow_custom=0, save_custom=0,
          layout="horizontal", toggle=0),
        f("dish_highlight", "Выделить название", "highlight", "true_false", 50,
          **{**toggle, "message": "Хит, сезонное, фирменное"}),
        f("dish_seasonal_ru", "Сезонная метка", "seasonal_ru", "text", 50, **{**text, "placeholder": "Лето’26!"}),
        f("dish_seasonal_en", "Сезонная метка (EN)", "seasonal_en", "text", 50, **text),
        f("dish_options_ru", "Опции", "options_ru", "textarea", 50,
          instructions="Каждая опция с новой строки.", **{**area, "rows": 3}),
        # The note is repeated on the twin on purpose: a note on one side only leaves the pair uneven.
        f("dish_options_en", "Опции (EN)", "options_en", "textarea", 50,
          instructions="Каждая опция с новой строки.", **{**area, "rows": 3}),
    ]
    return [name_en, *sizes, *descriptions, more, *extras]


def subsection_fields(prefix, dishes):
    """A subsection's header fields + its Relationship list of dishes."""
    f = lambda *a, **k: field(*a, parent="subsections", prefix=prefix, **k)
    return [
        f("sub_title_ru", "Подраздел", "title_ru", "text", 35, **{**text, "placeholder": "можно без заголовка"}),
        f("sub_title_en", "Подраздел (EN)", "title_en", "text", 35, **text),
        f("sub_column", "Колонка", "column", "select", 15,
          choices={"left": "Левая", "right": "Правая"}, default_value="left", allow_null=0, **select),
        f("sub_style", "Вид", "style", "select", 15,
          choices={"list": "Список", "card": "Карточка (добавки, соусы)"}, default_value="list", allow_null=0, **select),
        dishes,
        # Rare, so they sit under the list: a remark printed under the subsection (Kids: adult
        # pricing), and a rule that starts a new pair of columns (Tea & Coffee: tea under coffee).
        f("sub_note_ru", "Примечание под подразделом", "note_ru", "text", 40, **text),
        f("sub_note_en", "Примечание (EN)", "note_en", "text", 40, **text),
        f("sub_divider", "Черта перед подразделом", "divider", "true_false", 20,
          **{**toggle, "message": "Новый блок колонок"}),
    ]


def subsections(prefix, dishes):
    return field("subsections", "Подразделы и блюда", "menu_subsections", "repeater", prefix=prefix,
                 layout="block", pagination=0, min=0, max=0, collapsed=f"{prefix}sub_title_ru",
                 button_label="Добавить подраздел", rows_per_page=20, sub_fields=subsection_fields(prefix, dishes))


# ── The menu store ──
D = "field_sp_dish_"
dish = group(
    "group_sp_dish", "Блюдо", dish_fields(D), ["dish", "drink"],
    "One dish or drink. Generated by tools/menu-field-group.py; read by inc/menu-data-dishes.php.")

L = "field_sp_list_"
menu_list = group(
    "group_sp_menu_list", "Раздел меню — списки блюд", [
        field("hint", "", "", "message", prefix=L, message="Порядок блюд в списке — порядок на сайте: перетащите блюдо в правой колонке. "
              "Само блюдо (цена, описание) правится в «Блюдах» или «Напитках»; блюдо в черновике на сайте не показывается, но остаётся в списке.",
              new_lines="", esc_html=0),
        subsections(L, field("dishes", "Блюда", "dishes", "relationship", "", "subsections", prefix=L,
                             post_type=["dish", "drink"], post_status="", taxonomy="", filters=["search"],
                             return_format="id", min="", max="", elements="", bidirectional=0,
                             bidirectional_target=[])),
    ], "menu_list",
    "Subsections → ordered lists of `dish` posts, for one menu section. Generated by tools/menu-field-group.py; "
    "read by inc/menu-data-dishes.php.")

write_groups((dish, menu_list))
