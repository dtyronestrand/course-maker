
## 2024-05-09 - Accessible Icon Actions with Hover Visibility
**Learning:** In tables and lists where action icons (like Pencil for Edit or Trash2 for Delete) are only visible on row hover (`opacity-0 group-hover:opacity-100`), keyboard-only users and screen readers cannot access or see them easily. Furthermore, raw SVG icons aren't natively focusable or semantic buttons.
**Action:** Always wrap interactive SVGs in `<button>` tags with descriptive `aria-label`s. If the actions are hidden until hovered, add `focus-within:opacity-100` to the container (or the button itself) so that when a keyboard user tabs to the hidden button, it instantly becomes visible. Also, ensure the SVGs themselves have `role="img"` and `aria-hidden="true"`.
