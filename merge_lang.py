#!/usr/bin/env python3
import json, sys

def set_translation(d, dotted_key, value):
    d[dotted_key] = value

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
        set_translation(en, key, vals['en'])
        set_translation(fr, key, vals['fr'])
    with open(en_path, 'w') as f:
        json.dump(en, f, ensure_ascii=False, indent=4)
        f.write('\n')
    with open(fr_path, 'w') as f:
        json.dump(fr, f, ensure_ascii=False, indent=4)
        f.write('\n')
    print(f"Merged {len(entries)} keys.")

if __name__ == '__main__':
    main()
