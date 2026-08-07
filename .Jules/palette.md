
## 2024-05-18 - [Add explicit close button to modal]
**Learning:** Adding a native HTML <button> for closing modals, paired with visual feedback (hover styles) and keyboard focus indicators (focus-visible utilities), greatly improves modal accessibility. Pure custom overlays using only backdrop clicks require additional keyboard handlers and are not natively discoverable by screen readers unless properly labeled with roles and explicit action targets.
**Action:** When building or updating custom modals without pre-built UI library defaults, ensure an explicit and accessible close button (with an `aria-label`) is included in the header, and set appropriate ARIA roles on the modal container (`role="dialog"`, `aria-modal="true"`, `aria-labelledby`).
