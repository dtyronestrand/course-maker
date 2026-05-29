## 2024-05-18 - Missing Modal Close Buttons
**Learning:** Custom modals utilizing `@click.self` on the backdrop to close are entirely inaccessible to keyboard users because backdrops are not natively focusable or interactive. Modals must always include an explicit, focusable `<button>` (e.g., a close icon) with a proper `aria-label`.
**Action:** Always verify that every custom modal implements a focusable close button within the modal dialog itself, rather than relying solely on click-away behavior.
