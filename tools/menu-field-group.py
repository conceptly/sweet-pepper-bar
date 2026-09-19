#!/usr/bin/env python3
"""Generate sweet-pepper-theme/acf-json/group_sp_menu_section.json.

The menu section field group is generated, not clicked (website-brief.md →
Content editing: "Field groups are generated"). Edit the fields here and re-run:

    python3 tools/menu-field-group.py

Keys are fixed (`field_sp_menu_*`), so re-running never orphans saved values.
Field names are read by sweet-pepper-theme/inc/menu-data.php and tools/menu-seed.php.
"""
import json
import time
from pathlib import Path

OUT = Path(__file__).resolve().parent.parent / "sweet-pepper-theme/acf-json/group_sp_menu_section.json"


def field(key, label, name, type_, width="", parent=None, **extra):
    f = {
        "key": f"field_sp_menu_{key}", "label": label, "name": name, "aria-label": "",
        "type": type_, "instructions": extra.pop("instructions", ""), "required": extra.pop("required", 0),
        "conditional_logic": 0,
        "wrapper": {"width": str(width), "class": extra.pop("wrapper_class", ""), "id": ""},
    }
    f.update(extra)
    if parent:
        f["parent_repeater"] = f"field_sp_menu_{parent}"
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

P = "dishes"
dish_fields = [
    field("dish_name_ru", "Название", "name_ru", "text", 40, P, required=1, **text),
    field("dish_name_en", "Название (EN)", "name_en", "text", 40, P, **text),
    field("dish_hidden", "Скрыть с сайта", "hidden", "true_false", 20, P, **toggle),

    # Size 1, and an optional size 2 (40 мл / 500 мл → 150 / 1300).
    field("dish_amount", "Выход", "amount", "number", 14, P, **number),
    field("dish_unit", "Ед.", "unit", "select", 14, P, choices=UNITS, default_value="g", allow_null=0, **select),
    field("dish_price", "Цена", "price", "number", 22, P, **{**number, "append": "-."}),
    field("dish_amount_2", "Выход 2", "amount_2", "number", 14, P, **number),
    field("dish_unit_2", "Ед.", "unit_2", "select", 14, P, choices=UNITS, default_value="g", allow_null=0, **select),
    field("dish_price_2", "Цена 2", "price_2", "number", 22, P, **{**number, "append": "-."}),

    field("dish_description_ru", "Описание", "description_ru", "textarea", 50, P, **area),
    field("dish_description_en", "Описание (EN)", "description_en", "textarea", 50, P, **area),

    field("dish_more", "Дополнительно: значки, сезон, опции", "", "accordion", "", P, open=0, multi_expand=1, endpoint=0),
    field("dish_icons", "Значки — не больше двух", "icons", "checkbox", 50, P,
          choices=ICONS, default_value=[], return_format="value", allow_custom=0, save_custom=0,
          layout="horizontal", toggle=0),
    field("dish_highlight", "Выделить название", "highlight", "true_false", 50, P,
          **{**toggle, "message": "Хит, сезонное, фирменное"}),
    field("dish_seasonal_ru", "Сезонная метка", "seasonal_ru", "text", 50, P, **{**text, "placeholder": "Лето’26!"}),
    field("dish_seasonal_en", "Сезонная метка (EN)", "seasonal_en", "text", 50, P, **text),
    field("dish_options_ru", "Опции", "options_ru", "textarea", 50, P,
          instructions="Каждая опция с новой строки.", **{**area, "rows": 3}),
    # The note is repeated on the twin on purpose: a note on one side only leaves the pair uneven.
    field("dish_options_en", "Опции (EN)", "options_en", "textarea", 50, P,
          instructions="Каждая опция с новой строки.", **{**area, "rows": 3}),
    field("dish_id", "ID", "dish_id", "text", "", P, wrapper_class="sp-field-hidden", readonly=1, **text),
]

S = "subsections"
sub_fields = [
    field("sub_title_ru", "Подраздел", "title_ru", "text", 35, S, **{**text, "placeholder": "можно без заголовка"}),
    field("sub_title_en", "Подраздел (EN)", "title_en", "text", 35, S, **text),
    field("sub_column", "Колонка", "column", "select", 15, S,
          choices={"left": "Левая", "right": "Правая"}, default_value="left", allow_null=0, **select),
    field("sub_style", "Вид", "style", "select", 15, S,
          choices={"list": "Список", "card": "Карточка (добавки, соусы)"}, default_value="list", allow_null=0, **select),
    field("dishes", "Блюда", "dishes", "repeater", "", S, layout="block", pagination=0, min=0, max=0,
          collapsed="field_sp_menu_dish_name_ru", button_label="Добавить блюдо", rows_per_page=20,
          sub_fields=dish_fields),
]

group = {
    "key": "group_sp_menu_section",
    "title": "Раздел меню",
    "fields": [
        field("hint", "", "", "message", message="Порядок строк — порядок на сайте: перетащите строку за номер слева. "
              "«Скрыть с сайта» убирает блюдо не в сезоне, строка остаётся здесь.", new_lines="", esc_html=0),
        field("subsections", "Подразделы и блюда", "menu_subsections", "repeater",
              layout="block", pagination=0, min=0, max=0, collapsed="field_sp_menu_sub_title_ru",
              button_label="Добавить подраздел", rows_per_page=20, sub_fields=sub_fields),
    ],
    "location": [[{"param": "post_type", "operator": "==", "value": "menu_section"}]],
    "menu_order": 0, "position": "normal", "style": "seamless", "label_placement": "top",
    "instruction_placement": "field", "hide_on_screen": "", "active": True,
    "description": "Subsections → dishes of one menu section. Generated by tools/menu-field-group.py; read by inc/menu-data.php.",
    "show_in_rest": 0, "display_title": "", "allow_ai_access": False, "ai_description": "",
    "modified": int(time.time()),
}

OUT.write_text(json.dumps(group, ensure_ascii=False, indent=4) + "\n", encoding="utf-8")
print(f"wrote {OUT.name}: {len(dish_fields)} dish fields")
