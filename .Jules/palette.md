## 2023-10-27 - Vue Modal Accessibility
**Learning:** When building custom modals in Vue (e.g., using `@click.self` on a backdrop), ensuring they have an explicit `role="dialog"`, `aria-modal="true"`, and an `aria-labelledby` pointing to the title is critical for screen reader compatibility. Additionally, explicit ID association between labels and inputs is needed to prevent accessibility violations and improve focus.
**Action:** Always add ARIA dialog attributes and label-input ID bindings for custom modals and forms.
