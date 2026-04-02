
## 2024-05-27 - [Fix Missing Input IDs]
**Learning:** Some custom form components like the ones in `CourseDetails.vue` use `<label for="...">` but forget to add matching `id="..."` on the associated `<input>`. This breaks click-to-focus and screen reader association.
**Action:** Always ensure `for` and `id` match when dealing with inputs, regardless of whether `name` is set.
