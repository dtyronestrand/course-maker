## 2025-02-13 - Icon-only buttons accessibility
**Learning:** Icon-only buttons, especially in global navigation headers, often lack descriptive names, which creates a barrier for screen reader users. Additionally, visible icon components (like lucide-vue-next) should be explicitly hidden from screen readers using `aria-hidden="true"` to prevent redundant reading.
**Action:** Always wrap icon-only triggers with an `aria-label` attribute describing the action and add `aria-hidden="true"` to the inner decorative icon component.
