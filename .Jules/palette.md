
## 2024-05-18 - Missing ID attributes on form inputs
**Learning:** Found multiple form inputs in Vue components (e.g. `CourseDetails.vue`) where a `<label>` element uses `for="propName"`, but the corresponding `<input>` lacks the `id="propName"` attribute. This breaks screen reader association and click-to-focus functionality.
**Action:** Always verify that form `<input>`s, `<select>`s, and `<textarea>`s possess an explicitly defined `id` attribute that accurately matches the `for` attribute of their corresponding `<label>`.
