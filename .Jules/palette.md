
## 2025-02-26 - Accessible Action Icons in Render Functions
**Learning:** TanStack Vue table action cells using the `h()` render function often render raw interactive icons (like Lucide icons) without button wrappers, breaking keyboard accessibility and screen reader support. Furthermore, hover-only visibility utilities (e.g., `opacity-0 group-hover:opacity-100`) hide these elements from keyboard navigation.
**Action:** Always wrap interactive icons in an `h('button')` element with `aria-label`, `aria-hidden="true"` on the inner icon, and appropriate focus ring utilities (`focus-visible:ring-2 focus-visible:ring-ring`). Crucially, pair `group-hover:opacity-100` with `focus:opacity-100` on the wrapper to ensure focus indicators are visible when navigating via keyboard.

## 2024-05-15 - Icon-only buttons lack accessibility wrappers
**Learning:** Developers often attach `@click` events directly to SVG icons (`lucide-vue-next` components) without wrapping them in an accessible `<button>` element. This prevents keyboard navigation and screen reader announcements.
**Action:** Always wrap icon-only clickable elements in a `<button>` with an `aria-label`, an `aria-hidden="true"` attribute on the inner icon, and appropriate focus-visible classes (`focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 outline-none`).
