## 2024-05-17 - Add close buttons to custom modals
**Learning:** Custom Vue modals that rely solely on `@click.self` for closing via a backdrop click are not discoverable and can be inaccessible to keyboard users, as there is no visible focusable element inside the modal to trigger the close action.
**Action:** Always include an explicit close button (like an 'X' icon) in custom modal headers, complete with an `aria-label` and `focus-visible` styles to ensure keyboard accessibility.
