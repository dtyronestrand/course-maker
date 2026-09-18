## 2024-05-18 - Modal Accessibility Standard
**Learning:** Custom modals (especially those utilizing `@click.self` on backdrops) across this app often lack explicit dialog roles and close buttons, which creates keyboard navigation traps or inaccessible experiences for screen reader users.
**Action:** Always ensure that custom modals wrap content in a container with `role="dialog"`, `aria-modal="true"`, an appropriate `aria-labelledby` referencing the title id, and an explicit close button with `aria-label="Close modal"` to meet fundamental accessibility standards.
