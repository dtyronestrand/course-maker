## 2024-05-17 - Add close buttons to custom modals
**Learning:** Custom Vue modals that rely solely on `@click.self` for closing via a backdrop click are not discoverable and can be inaccessible to keyboard users, as there is no visible focusable element inside the modal to trigger the close action.
**Action:** Always include an explicit close button (like an 'X' icon) in custom modal headers, complete with an `aria-label` and `focus-visible` styles to ensure keyboard accessibility.


## 2025-02-26 - Accessible Action Icons in Render Functions
**Learning:** TanStack Vue table action cells using the `h()` render function often render raw interactive icons (like Lucide icons) without button wrappers, breaking keyboard accessibility and screen reader support. Furthermore, hover-only visibility utilities (e.g., `opacity-0 group-hover:opacity-100`) hide these elements from keyboard navigation.
**Action:** Always wrap interactive icons in an `h('button')` element with `aria-label`, `aria-hidden="true"` on the inner icon, and appropriate focus ring utilities (`focus-visible:ring-2 focus-visible:ring-ring`). Crucially, pair `group-hover:opacity-100` with `focus:opacity-100` on the wrapper to ensure focus indicators are visible when navigating via keyboard.

## 2024-10-15 - Improve TanStack Table Filter Accessibility
**Learning:** TanStack Vue table custom filter components often lack built-in accessibility (like `aria-label`s on filter inputs and toggle buttons).
**Action:** When implementing table filters, ensure focus rings (`focus-visible`) and ARIA attributes (`aria-label`, `aria-expanded`, `aria-haspopup`) are explicitly added to interactive elements to support screen readers and keyboard navigation.
