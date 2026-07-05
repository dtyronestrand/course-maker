## 2024-07-05 - Accessible actions in TanStack table definitions
**Learning:** When using TanStack table in Vue with custom `h()` render functions, raw icon components attached with click handlers lack keyboard accessibility and semantics.
**Action:** Always wrap interactive icon-only elements inside an `h('button')` element containing an `aria-label` and `focus-visible:ring-2` utility classes to support screen readers and keyboard navigation.
