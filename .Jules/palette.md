## 2024-07-03 - [Targeted UI/UX improvements]
**Learning:** When applying UI/UX micro-improvements, resolving pre-existing linting errors (like unused variables) in unrelated files introduces scope creep and risks PR rejection due to unrelated, potentially breaking changes.
**Action:** Strictly isolate changes to the target file. Ignore and do not attempt to fix pre-existing linting errors across the codebase unless explicitly requested.
