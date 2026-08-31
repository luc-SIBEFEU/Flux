#!/usr/bin/env python3
"""Apply a list of exact-match string replacements to a file.
Usage: python3 apply_replacements.py <target_file> <replacements.json>
replacements.json: [[old_str, new_str], ...] applied in order, each expected to match exactly once.
"""
import sys, json

def main():
    target = sys.argv[1]
    repl_path = sys.argv[2]
    with open(repl_path) as f:
        pairs = json.load(f)

    with open(target, 'r', encoding='utf-8') as f:
        content = f.read()

    errors = []
    for old, new in pairs:
        count = content.count(old)
        if count == 0:
            errors.append(f"NOT FOUND: {old[:80]!r}")
            continue
        if count > 1:
            errors.append(f"MULTIPLE ({count}x): {old[:80]!r}")
            continue
        content = content.replace(old, new, 1)

    with open(target, 'w', encoding='utf-8') as f:
        f.write(content)

    if errors:
        print(f"{len(errors)} issues out of {len(pairs)}:")
        for e in errors:
            print(" -", e)
    else:
        print(f"OK: applied {len(pairs)} replacements to {target}")

if __name__ == '__main__':
    main()
