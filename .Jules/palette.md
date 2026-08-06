
## 2026-08-06 - Table Row Hover Actions Accessibility
**Learning:** Interactive icons hidden via 'opacity-0 group-hover:opacity-100' are completely inaccessible to keyboard users because they remain invisible when focused.
**Action:** Always add 'focus:opacity-100' to the focused element (or 'focus-within:opacity-100' to the parent) to ensure keyboard users can see the element they tabbed to.
