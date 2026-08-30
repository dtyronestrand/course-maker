## 2026-08-30 - Added accessibility to Filter component
**Learning:** TanStack Vue table components (e.g., filters and headers) often lack built-in accessibility. Custom buttons inside dropdowns need focus rings, `aria-label`, and `:aria-expanded`.
**Action:** Always explicitly add `aria-label` attributes indicating their operation and `focus-visible` UI indicators to interactive elements inside custom components.
