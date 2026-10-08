
## 2025-01-22 - Explicit Close Buttons on Custom Modals
**Learning:** Custom modals that rely solely on `@click.self` on the background for closing are inaccessible to keyboard-only users and screen readers, as they cannot focus on the background.
**Action:** Always include an explicit close button with `aria-label` and `focus-visible` styling inside custom modals, and apply `role="dialog"` and `aria-modal="true"` to the modal container.
