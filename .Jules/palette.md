## 2024-05-18 - Applying role="button" to Structural Elements
**Learning:** Adding `role="button"` directly to structural container elements like `<li>` breaks the expected semantic HTML hierarchy in the accessibility tree (e.g., turning a list item into an isolated button instead of maintaining list semantics).
**Action:** When making cards or list items interactive, avoid applying `role="button"` directly to the container if it breaks semantics. Instead, use an inner `<button>` wrapper for the clickable content or an absolutely positioned pseudo-link.
## 2024-05-18 - Overriding Visible Text with aria-label
**Learning:** Applying an `aria-label` to a container element that already has meaningful text children causes screen readers to read *only* the `aria-label` and completely ignore the visible child text, causing users to miss context (like status or metadata).
**Action:** Do not use `aria-label` on elements that contain meaningful text intended to be read. Reserve `aria-label` for icon-only buttons or elements where the visible text is insufficient or non-existent.
