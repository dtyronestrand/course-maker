## 2024-05-24 - explicit modal close actions
**Learning:** Relied on \`@click.self\` to close modals. A keyboard navigation or screen reader user cannot easily trigger these backdrop-closing areas.
**Action:** Always provide explicit close buttons with \`aria-label\` for modal/dialog components when they rely on backdrop-clicking for closure to ensure proper focus navigation and explicit semantic actions.
