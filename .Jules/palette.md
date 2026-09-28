## 2024-05-15 - Interactive Filter Components
**Learning:** Custom interactive elements (like icon-only toggle buttons and dropdowns) inside dynamic table components often lack basic accessibility attributes and focus indicators when initially built.
**Action:** Always explicitly add `aria-expanded`, `aria-haspopup`, and `aria-hidden="true"` to inner decorative icons for custom filter dropdowns. Ensure they have explicit `focus-visible` states using Tailwind utility classes.
