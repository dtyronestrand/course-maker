
## 2024-05-27 - [Fix Missing Input IDs]
**Learning:** Some custom form components like the ones in `CourseDetails.vue` use `<label for="...">` but forget to add matching `id="..."` on the associated `<input>`. This breaks click-to-focus and screen reader association.
**Action:** Always ensure `for` and `id` match when dealing with inputs, regardless of whether `name` is set.
## 2024-05-18 - Accessible Icon Buttons in TanStack Tables
**Learning:** TanStack table custom cell renderers using `h()` often lack implicit accessibility for icon-only action targets like "Edit" or "Delete" icons, preventing screen reader announcements and keyboard navigation. Using `opacity-0` for visually hiding actions until hovered exacerbates this issue.
**Action:** When implementing icon-only click targets in Vue render functions `h()`, explicitly wrap them in a semantically correct `button` element, append an `aria-label`, apply standard focus rings (`focus-visible:ring-2 ... outline-none`), and ensure visually hidden elements become visible on focus (`focus:opacity-100`).

## 2025-02-26 - Accessible Action Icons in Render Functions
**Learning:** TanStack Vue table action cells using the `h()` render function often render raw interactive icons (like Lucide icons) without button wrappers, breaking keyboard accessibility and screen reader support. Furthermore, hover-only visibility utilities (e.g., `opacity-0 group-hover:opacity-100`) hide these elements from keyboard navigation.
**Action:** Always wrap interactive icons in an `h('button')` element with `aria-label`, `aria-hidden="true"` on the inner icon, and appropriate focus ring utilities (`focus-visible:ring-2 focus-visible:ring-ring`). Crucially, pair `group-hover:opacity-100` with `focus:opacity-100` on the wrapper to ensure focus indicators are visible when navigating via keyboard.
## 2024-10-15 - Improve TanStack Table Filter Accessibility
**Learning:** TanStack Vue table custom filter components often lack built-in accessibility (like `aria-label`s on filter inputs and toggle buttons).
**Action:** When implementing table filters, ensure focus rings (`focus-visible`) and ARIA attributes (`aria-label`, `aria-expanded`, `aria-haspopup`) are explicitly added to interactive elements to support screen readers and keyboard navigation.
