## 2024-08-15 - Global Formatters Scope Creep
**Learning:** Running `pnpm format` (which executes `prettier --write resources/`) in this codebase modifies dozens of unrelated files, creating a massive, unreviewable patch that violates the "<50 lines" boundary constraint for micro-UX PRs.
**Action:** Avoid global formatting scripts. Only manually format modified files or explicitly target the formatter at the single file modified.
