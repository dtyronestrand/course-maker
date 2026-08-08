## 2025-01-01 - [Modal Close Button Accessibility]
**Learning:** Custom modals (e.g. ones with `@click.self="emit('modal-close')"` on the backdrop) need an explicit button inside the dialog that users can tab to and interact with (using Space or Enter) to close the modal. Relying solely on backdrop clicks leaves keyboard and screen reader users trapped.
**Action:** Always provide an explicit, focusable close button (with an `aria-label` and visible focus states) inside all custom modals, ensuring they have `role="dialog"` and are properly labeled.
