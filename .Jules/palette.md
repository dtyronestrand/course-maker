## 2025-02-28 - Explicit Close Buttons on Modals
**Learning:** Custom modals lacking explicit close buttons inside their content (relying solely on backdrop clicks) create severe accessibility barriers for screen reader and keyboard-only users who cannot easily trigger the background click event.
**Action:** When building custom modals, ensure they always have an explicit and accessible close button (with `aria-label` and `focus-visible` styles) in the header.
