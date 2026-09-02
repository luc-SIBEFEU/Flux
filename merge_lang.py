#!/usr/bin/env python3
import json, sys

def set_nested(d, dotted_key, value):
    parts = dotted_key.split('.')
    cur = d
    for p in parts[:-1]:
        cur = cur.setdefault(p, {})
    cur[parts[-1]] = value

def main():
    entries_path = sys.argv[1]
    with open(entries_path) as f:
        entries = json.load(f)
    en_path = 'resources/lang/en.json'
    fr_path = 'resources/lang/fr.json'
    with open(en_path) as f:
        en = json.load(f)
    with open(fr_path) as f:
        fr = json.load(f)
    for key, vals in entries.items():
        set_nested(en, key, vals['en'])
        set_nested(fr, key, vals['fr'])
    with open(en_path, 'w') as f:
        json.dump(en, f, ensure_ascii=False, indent=4)
        f.write('\n')
    with open(fr_path, 'w') as f:
        json.dump(fr, f, ensure_ascii=False, indent=4)
        f.write('\n')
    print(f"Merged {len(entries)} keys.")

if __name__ == '__main__':
    main()
