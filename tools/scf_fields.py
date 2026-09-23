"""What the field-group generators share (menu-field-group.py, page-field-groups.py).

Field groups are generated, not clicked (website-brief.md → Content editing:
"Field groups are generated"). Keys are fixed, so re-running never orphans saved values.
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


def group(key, title, fields, location, description, menu_order=0):
    """`location` is a post type, a full rule: {"param": …, "operator": "==", "value": …},
    or a list of either — any one of them matches (SCF's OR groups)."""
    rule = lambda l: {"param": "post_type", "operator": "==", "value": l} if isinstance(l, str) else l
    rules = [[rule(l)] for l in (location if isinstance(location, list) else [location])]
    return {
        "key": key,
        "title": title,
        "fields": fields,
        "location": rules,
        "menu_order": menu_order, "position": "normal", "style": "seamless", "label_placement": "top",
        "instruction_placement": "field", "hide_on_screen": "", "active": True,
        "description": description,
        "show_in_rest": 0, "display_title": "", "allow_ai_access": False, "ai_description": "",
        "modified": int(time.time()),
    }


def write_groups(groups):
    for g in groups:
        path = OUT / f"{g['key']}.json"
        # `modified` is what makes SCF offer "Sync available": leave an unchanged group's file
        # alone, or every run asks the team to sync every group.
        if path.exists():
            old = json.loads(path.read_text(encoding="utf-8"))
            if {**old, "modified": 0} == {**g, "modified": 0}:
                print(f"unchanged {path.name}")
                continue
        path.write_text(json.dumps(g, ensure_ascii=False, indent=4) + "\n", encoding="utf-8")
        print(f"wrote {path.name}")
