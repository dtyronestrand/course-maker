## 2026-08-19 - [Hover-only Interactions Need Focus States]
**Learning:** Elements styled with `opacity-0 group-hover:opacity-100` are completely invisible to keyboard users who navigate via the Tab key, creating an accessibility barrier for hidden interactive elements like edit buttons.
**Action:** When creating hover-revealed interactive elements, always pair `group-hover:opacity-100` with `focus-within:opacity-100` on the parent, and ensure the interactive element itself has a proper `tabindex="0"`, semantic aria-labels, and explicit focus indicators (e.g., `focus-visible:ring-2`).
