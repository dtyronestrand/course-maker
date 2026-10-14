
## 2025-02-26 - Accessible Action Icons in Render Functions
**Learning:** TanStack Vue table action cells using the `h()` render function often render raw interactive icons (like Lucide icons) without button wrappers, breaking keyboard accessibility and screen reader support. Furthermore, hover-only visibility utilities (e.g., `opacity-0 group-hover:opacity-100`) hide these elements from keyboard navigation.
**Action:** Always wrap interactive icons in an `h('button')` element with `aria-label`, `aria-hidden="true"` on the inner icon, and appropriate focus ring utilities (`focus-visible:ring-2 focus-visible:ring-ring`). Crucially, pair `group-hover:opacity-100` with `focus:opacity-100` on the wrapper to ensure focus indicators are visible when navigating via keyboard.

## 2025-02-26 - Accessible Icon-Only Buttons for Copy Actions
**Learning:** Icon-only buttons used for secondary actions (like copying setup keys) often lack accessibility labels and visible focus rings. Relying only on hover states hides them from keyboard navigation and screen readers.
**Action:** Always add an `aria-label` to icon-only buttons, set `aria-hidden="true"` on the inner decorative icons (e.g., Lucide icons), and include explicit focus state utilities (`focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none`) to ensure full accessibility.
