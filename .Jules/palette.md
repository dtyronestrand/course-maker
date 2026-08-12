## 2024-03-24 - Accessibility pattern for icon-only buttons in UI components
**Learning:** Icon-only buttons used in the global `AppHeader` component for navigation, search, and menus frequently lack accessible names. Adding `aria-label` attributes to these components provides immediate accessibility for screen readers without changing visual design.
**Action:** Always verify custom icon buttons (especially those built on top of primitives like `reka-ui` or generic `<Button>` components) for `aria-label` attributes.
