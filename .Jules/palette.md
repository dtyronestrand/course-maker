
## 2024-05-18 - Filter Menu Keyboard Accessibility
**Learning:** The custom `Filter.vue` component used an icon-only `<button>` for its dropdown trigger without any `aria-label`, `:aria-expanded` state, or visible focus ring. This made it inaccessible to screen readers and keyboard users.
**Action:** Always ensure custom icon-only toggle buttons include `aria-label`, `:aria-expanded` dynamically bound to their open state, `aria-hidden="true"` on the inner SVG/icon, and visible focus rings using Tailwind utilities (`focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary`).
