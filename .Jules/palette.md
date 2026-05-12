## 2024-05-12 - Missing Close Buttons in Modal Dialogs
**Learning:** Found that custom modal components (like `CourseDetails.vue`) often lack an explicit, accessible close button, relying solely on clicking outside or an action button at the bottom. This pattern is problematic for screen reader users or users navigating primarily by keyboard who expect an explicitly labeled close control near the top of the dialog content.
**Action:** Always ensure modals have a clear `aria-label="Close modal"` button in the header, keeping styling and behavior consistent across all dialog components.
