## 2024-05-14 - Accessibility in Modals
**Learning:** In custom built Vue modals, even if clicking the background handles closing, explicit close buttons and dialog roles (role="dialog", aria-modal="true") are crucial for screen readers. Explicitly linking labels to inputs using matching 'for' and 'id' attributes enables click-to-focus and screen reader association.
**Action:** Always check custom dialog implementations for complete ARIA attribute inclusion and always map labels explicitly to input fields using matching ids in custom forms.
