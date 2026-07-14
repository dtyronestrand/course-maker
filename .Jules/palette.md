## 2024-07-14 - Icon-only Dropdown Button Accessibility
**Learning:** Icon-only buttons used for dropdown toggles (like in Filter.vue) are often missing `aria-label`, `aria-expanded`, and explicit focus styling, making them invisible to screen readers and difficult to use via keyboard navigation.
**Action:** When auditing dropdown toggles, always ensure they have an explicit `aria-label` or visible text, dynamically bind `:aria-expanded` to the toggle state, and explicitly apply `focus-visible:ring-2 focus-visible:outline-none` for keyboard usability.
