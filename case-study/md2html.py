import sys, re
import html

def md_to_html(md_text):
    # Escape HTML
    md_text = html.escape(md_text)
    
    # Headers
    md_text = re.sub(r'(?m)^### (.*)$', r'<h3>\1</h3>', md_text)
    md_text = re.sub(r'(?m)^## (.*)$', r'<h2>\1</h2>', md_text)
    md_text = re.sub(r'(?m)^# (.*)$', r'<h1>\1</h1>', md_text)
    
    # Bold / Italic
    md_text = re.sub(r'\*\*(.*?)\*\*', r'<b>\1</b>', md_text)
    md_text = re.sub(r'\*(.*?)\*', r'<i>\1</i>', md_text)
    
    # Lists
    md_text = re.sub(r'(?m)^\* (.*)$', r'<li>\1</li>', md_text)
    
    # simple wrap consecutive lis in ul
    lines = md_text.split('\n')
    in_ul = False
    new_lines = []
    for line in lines:
        if line.startswith('<li>'):
            if not in_ul:
                new_lines.append('<ul>')
                in_ul = True
            new_lines.append(line)
        else:
            if in_ul:
                new_lines.append('</ul>')
                in_ul = True # wait this is false
                in_ul = False
            new_lines.append(line)
    if in_ul:
        new_lines.append('</ul>')
    md_text = '\n'.join(new_lines)
    
    # Paragraphs
    paragraphs = []
    for p in md_text.split('\n\n'):
        if p.strip() and not p.startswith('<h') and not p.startswith('<ul'):
            paragraphs.append(f'<p>{p.strip()}</p>')
        elif p.strip():
            paragraphs.append(p.strip())
            
    body = '\n\n'.join(paragraphs)
    
    return f"""<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style>
body {{ font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #333; max-width: 800px; margin: 40px auto; padding: 0 20px; }}
h1 {{ border-bottom: 1px solid #eaecef; padding-bottom: .3em; }}
h2 {{ border-bottom: 1px solid #eaecef; padding-bottom: .3em; margin-top: 1.5em; }}
ul {{ padding-left: 2em; margin-bottom: 16px; }}
li {{ margin-bottom: .5em; }}
p {{ margin-bottom: 16px; }}
</style>
</head>
<body>
{body}
</body>
</html>"""

for arg in sys.argv[1:]:
    with open(arg, 'r') as f:
        md = f.read()
    html_content = md_to_html(md)
    with open(arg.replace('.md', '.html'), 'w') as f:
        f.write(html_content)
