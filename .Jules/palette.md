## 2024-10-24 - Accessibility pattern for Custom Modals and Labels
**Learning:** Custom modals (especially Vue components like CourseDetails) frequently lack proper ARIA dialog roles (`role="dialog"`, `aria-modal="true"`), and form labels are often disconnected from their inputs (missing matching `id` attributes).
**Action:** Always verify that custom modal wrappers declare their semantics appropriately and that all `<label>` elements accurately map to an input's `id` for screen readers.
