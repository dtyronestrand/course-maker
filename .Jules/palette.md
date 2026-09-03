
## 2024-05-18 - AppHeader Icon-Only Buttons Accessibility
**Learning:** Found multiple icon-only navigation and action buttons (menu, search, user dropdown) in the main AppHeader component using shadcn UI components that lacked descriptive `aria-label`s, rendering them ambiguous to screen reader users.
**Action:** Always verify that components like `<Button size="icon">` or `<SheetTrigger>` used primarily for visual icons have explicit `aria-label` attributes to ensure they are fully accessible.
