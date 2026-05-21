
## 2024-05-14 - Accessible Icon-Only Actions
**Learning:** Adding a focusable `button` with `aria-label` inside a container hidden with `opacity-0 group-hover:opacity-100` makes it inaccessible to keyboard users because the container remains `opacity-0` when the button is focused. Adding `focus-within:opacity-100` to the container solves this.
**Action:** Always pair `group-hover:opacity-100` with `focus-within:opacity-100` on parent containers of visually hidden interactive elements to ensure they are visible when keyboard focused.
