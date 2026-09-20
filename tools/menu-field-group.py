#!/usr/bin/env python3
"""Generate the menu field groups in sweet-pepper-theme/acf-json/.

The menu field groups are generated, not clicked (website-brief.md →
Content editing: "Field groups are generated"). Edit the fields here and re-run:

    python3 tools/menu-field-group.py

Two stores are under test on Soups (website-brief.md → Menu storage); the loser's
groups are deleted from here and from acf-json/:
  group_sp_menu_section.json — repeater store: subsections → dish rows, on a `menu_section` record
  group_sp_dish.json         — dishes store: the same dish fields, on a `dish` post
  group_sp_menu_list.json    — dishes store: subsections → ordered Relationship lists, on a `menu_list` record

Keys are fixed (`field_sp_menu_*`, `field_sp_dish_*`, `field_sp_list_*`), so re-running never
orphans saved values. Field names are read by sweet-pepper-theme/inc/menu-data.php,
inc/menu-data-dishes.php and tools/menu-seed.php.
"""
import json
import time
from pathlib import Path

OUT = Path(__file__).resolve().parent.parent / "sweet-pepper-theme/acf-json"


def field(key, label, name, type_, width="", parent=None, prefix="field_sp_menu_", **extra):
    f = {
        "key": f"{prefix}{key}", "label": label, "name": name, "aria-label": "",
        "type": type_, "instructions": extra.pop("instructions", ""), "required": extra.pop("required", 0),
        "conditional_logic": 0,
        "wrapper": {"width": str(width), "class": extra.pop("wrapper_class", ""), "id": ""},
    }
    f.update(extra)
    if parent:
        f["parent_repeater"] = f"{prefix}{parent}"
    return f


text = dict(default_value="", maxlength="", placeholder="", prepend="", append="")
area = dict(default_value="", maxlength="", rows=2, placeholder="", new_lines="")
toggle = dict(message="", default_value=0, ui=1, ui_on_text="Да", ui_off_text="Нет")
number = dict(default_value="", min=0, max="", step="", placeholder="", prepend="", append="")
select = dict(return_format="value", multiple=0, ui=0, ajax=0, placeholder="")

# The theme holds the EN twin of each unit (inc/menu-data.php → sweet_pepper_menu_units()).
UNITS = {"g": "г", "ml": "мл", "l": "л", "pcs": "шт"}
# Values are file names in assets/icons/. Order here = order on the page.
# Legend (author, Sep 2026): leaf = vegetarian, fire = hit, pepper = spicy, Yaroslavl logo = local dish.
ICONS = {"veg": "Лист — вегетарианское", "fire": "Огонь — хит", "Pepper": "Перец — острое", "yaroslavl-logo": "Ярославль — местное блюдо"}

def dish_fields(prefix, parent=None):
    """A dish's fields — one definition for both stores, so the test compares the
    structure, not the form. A repeater row (parent set) also carries what a post
    has of its own: the RU name (a post's title), the hide switch (a post goes to
    Draft) and the stable id (a post has its ID)."""
    row = parent is not None
    f = lambda *a, **k: field(*a, parent=parent, prefix=prefix, **k)
    return [
        *([f("dish_name_ru", "Название", "name_ru", "text", 40, required=1, **text)] if row else []),
        f("dish_name_en", "Название (EN)", "name_en", "text", 40 if row else "", **text),
        *([f("dish_hidden", "Скрыть с сайта", "hidden", "true_false", 20, **toggle)] if row else []),

        # Size 1, and an optional size 2 (40 мл / 500 мл → 150 / 1300).
        f("dish_amount", "Выход", "amount", "number", 14, **number),
        f("dish_unit", "Ед.", "unit", "select", 14, choices=UNITS, default_value="g", allow_null=0, **select),
        f("dish_price", "Цена", "price", "number", 22, **{**number, "append": "-."}),
        f("dish_amount_2", "Выход 2", "amount_2", "number", 14, **number),
        f("dish_unit_2", "Ед.", "unit_2", "select", 14, choices=UNITS, default_value="g", allow_null=0, **select),
        f("dish_price_2", "Цена 2", "price_2", "number", 22, **{**number, "append": "-."}),

        f("dish_description_ru", "Описание", "description_ru", "textarea", 50, **area),
        f("dish_description_en", "Описание (EN)", "description_en", "textarea", 50, **area),

        f("dish_more", "Дополнительно: значки, сезон, опции", "", "accordion", "", open=0, multi_expand=1, endpoint=0),
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
        *([f("dish_id", "ID", "dish_id", "text", "", wrapper_class="sp-field-hidden", readonly=1, **text)] if row else []),
    ]


def subsection_fields(prefix, dishes):
    """A subsection's header fields + its dishes — a repeater of rows, or a Relationship list."""
    f = lambda *a, **k: field(*a, parent="subsections", prefix=prefix, **k)
    return [
        f("sub_title_ru", "Подраздел", "title_ru", "text", 35, **{**text, "placeholder": "можно без заголовка"}),
        f("sub_title_en", "Подраздел (EN)", "title_en", "text", 35, **text),
        f("sub_column", "Колонка", "column", "select", 15,
          choices={"left": "Левая", "right": "Правая"}, default_value="left", allow_null=0, **select),
        f("sub_style", "Вид", "style", "select", 15,
          choices={"list": "Список", "card": "Карточка (добавки, соусы)"}, default_value="list", allow_null=0, **select),
        dishes,
    ]


def group(key, title, fields, post_type, description):
    return {
        "key": key,
        "title": title,
        "fields": fields,
        "location": [[{"param": "post_type", "operator": "==", "value": post_type}]],
        "menu_order": 0, "position": "normal", "style": "seamless", "label_placement": "top",
        "instruction_placement": "field", "hide_on_screen": "", "active": True,
        "description": description,
        "show_in_rest": 0, "display_title": "", "allow_ai_access": False, "ai_description": "",
        "modified": int(time.time()),
    }


def subsections(prefix, dishes):
    return field("subsections", "Подразделы и блюда", "menu_subsections", "repeater", prefix=prefix,
                 layout="block", pagination=0, min=0, max=0, collapsed=f"{prefix}sub_title_ru",
                 button_label="Добавить подраздел", rows_per_page=20, sub_fields=subsection_fields(prefix, dishes))


# ── Repeater store ──
M = "field_sp_menu_"
menu_section = group(
    "group_sp_menu_section", "Раздел меню", [
        field("hint", "", "", "message", message="Порядок строк — порядок на сайте: перетащите строку за номер слева. "
              "«Скрыть с сайта» убирает блюдо не в сезоне, строка остаётся здесь.", new_lines="", esc_html=0),
        subsections(M, field("dishes", "Блюда", "dishes", "repeater", "", "subsections", layout="block", pagination=0,
                             min=0, max=0, collapsed=f"{M}dish_name_ru", button_label="Добавить блюдо",
                             rows_per_page=20, sub_fields=dish_fields(M, "dishes"))),
    ], "menu_section",
    "Subsections → dishes of one menu section. Generated by tools/menu-field-group.py; read by inc/menu-data.php.")

# ── Dishes store ──
D = "field_sp_dish_"
dish = group(
    "group_sp_dish", "Блюдо", dish_fields(D), "dish",
    "One dish. Generated by tools/menu-field-group.py; read by inc/menu-data-dishes.php.")

L = "field_sp_list_"
menu_list = group(
    "group_sp_menu_list", "Раздел меню — списки блюд", [
        field("hint", "", "", "message", prefix=L, message="Порядок блюд в списке — порядок на сайте: перетащите блюдо в правой колонке. "
              "Само блюдо (цена, описание) правится в «Блюдах»; блюдо в черновике на сайте не показывается, но остаётся в списке.",
              new_lines="", esc_html=0),
        subsections(L, field("dishes", "Блюда", "dishes", "relationship", "", "subsections", prefix=L,
                             post_type=["dish"], post_status="", taxonomy="", filters=["search"],
                             return_format="id", min="", max="", elements="", bidirectional=0,
                             bidirectional_target=[])),
    ], "menu_list",
    "Subsections → ordered lists of `dish` posts, for one menu section. Generated by tools/menu-field-group.py; "
    "read by inc/menu-data-dishes.php.")

for g in (menu_section, dish, menu_list):
    path = OUT / f"{g['key']}.json"
    path.write_text(json.dumps(g, ensure_ascii=False, indent=4) + "\n", encoding="utf-8")
    print(f"wrote {path.name}")
