## 2024-10-04 - Unreachable Hover State Discovery

**Learning:** When using `opacity-0 group-hover:opacity-100` to hide interactive elements until hover (like edit/delete icons), these elements become completely invisible and inaccessible to keyboard users navigating via Tab, as they never receive a "hover" event.
**Action:** Always pair `group-hover:opacity-100` with `focus-within:opacity-100` on the parent container (or `focus:opacity-100` directly on the focusable element) to ensure keyboard navigation reveals the elements properly.
