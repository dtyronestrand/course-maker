## 2026-06-25 - Focus-within for Hidden Table Actions
**Learning:** In interactive tables where row actions (like Edit/Delete) are hidden using `opacity-0 group-hover:opacity-100`, they become completely inaccessible to keyboard users tabbing through the interface because they remain invisible when focused.
**Action:** Always pair `group-hover:opacity-100` with `focus-within:opacity-100` on the parent container (or `focus:opacity-100` on the element itself) to ensure keyboard navigation reveals the hidden actions.
