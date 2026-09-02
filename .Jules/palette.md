
## 2024-05-18 - Filter Toggle Button Accessibility
**Learning:** Icon-only toggle buttons in standard components (like `Filter.vue` using `ListFilter` icon) often lack `aria-label`, `:aria-expanded`, and explicit focus visible rings by default in this design system, making them inaccessible to screen readers and keyboard users.
**Action:** When working on interactive icon buttons, always verify and explicitly add `aria-label`, `:aria-expanded` (if it toggles state), and `focus-visible:ring-2 focus-visible:ring-primary outline-none` to ensure complete accessibility compliance.
