## 2024-05-20 - Ensure native events are emitted properly in Vue 3 Templates
**Learning:** While `emit` is available natively in Vue templates, it only works if explicitly initialized via `const emit = defineEmits(...)` and exposed. Using the globally injected `$emit` ensures events are reliably dispatched without relying on script setup boilerplate.
**Action:** When dispatching simple inline events from Vue `<template>` blocks, prefer using `$emit('event-name')` over `emit('event-name')` to avoid `_ctx.emit is not a function` errors.
