
## 2026-10-09 - Added aria-label to icon-only Buttons in AppHeader
**Learning:** In the Vue shadcn UI implementation, `Button` components are frequently used as wrappers for icon-only interactions (e.g., `SheetTrigger`, `DropdownMenuTrigger`). It's important to provide `aria-label` attributes on these wrappers to ensure screen readers announce the button's action correctly.
**Action:** Always add an `aria-label` to icon-only `Button` elements. Apply `aria-hidden="true"` on the inner icons to prevent redundant or confusing announcements by screen readers.
