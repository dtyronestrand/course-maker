## 2024-05-18 - Modals Need Explicit Accessibility

**Learning:** Custom modal components built natively (without relying on shadcn-vue `Dialog` or similar) in this app frequently lack proper ARIA dialog roles (`role="dialog"`, `aria-modal="true"`) and explicitly labeled close buttons (`aria-label="Close modal"`). Even if clicking the backdrop closes the modal, screen reader users and keyboard navigators require these explicit attributes for proper interaction and trap context.
**Action:** Always verify that custom modal wrappers utilize `role="dialog"` and `aria-labelledby`, and ensure any custom close buttons (especially icon-only SVG buttons) have an `aria-label` and `focus-visible:ring` applied for keyboard accessibility.
