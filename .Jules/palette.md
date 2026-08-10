## 2024-08-10 - Added Aria Labels and Focus Rings to TanStack Table Filter
**Learning:** Reusable interactive table components often rely on hidden or custom logic (like `div` or generic `<button>` elements) without considering accessibility requirements for screen readers or keyboard navigation. Tanstack Vue table headers and filters must have explicit `aria-label` attributes indicating their filter operation and `focus-visible` UI indicators.
**Action:** Standardize TanStack table filters to always include focus indicators and aria tags describing the input operations.
