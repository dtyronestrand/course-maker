
## 2024-07-19 - Improved CourseList accessibility
**Learning:** Found a common anti-pattern where a semantic `<li>` was used as an interactive item (`@click`) missing screen reader and keyboard interactions. Adding a semantic `role="button"` or `<div>` wrapped within the `<li>` is the correct approach to preserve structural HTML semantics while achieving accessibility.
**Action:** Always extract interaction to an inner container (e.g. `<div role="button">` with `tabindex="0"`, `aria-label`, and `@keydown.enter`/`@keydown.space.prevent`) when interactive elements are inside semantic structural elements like `<li>`.
