## 2024-05-19 - Do not modify global layout patterns
**Learning:** Modifying global styles like `html, body` in `app.css` to fix responsive issues, even when suggested in a generic UX list, violates the safe boundaries of micro-UX improvements as it causes massive application-wide layout regressions.
**Action:** Always restrict UX changes to specific, isolated UI components (like individual buttons or inputs) rather than changing global CSS rules that affect the entire page skeleton.

## 2024-05-19 - Filter Button Accessibility
**Learning:** The `Filter.vue` component used an icon-only button without an `aria-label` or focus indicator, which hid the filter functionality from screen readers and keyboard-only users.
**Action:** When adding icon-only buttons, especially toggles, always include an `aria-label`, an `aria-expanded` state if applicable, and explicit `focus-visible` Tailwind rings to ensure accessibility and keyboard discoverability.
