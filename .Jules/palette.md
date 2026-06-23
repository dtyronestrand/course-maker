## 2024-05-15 - Missing ID attributes breaking form label associations
**Learning:** Found a common pattern in the custom Vue form components where `<label>` elements have `for` attributes, but the corresponding `<input>` and `<textarea>` elements lack matching `id` attributes. This breaks screen reader associations and prevents users from clicking the label to focus the input.
**Action:** Always ensure that every form label specifically references an explicit `id` on its target input element, especially in custom-built forms outside the standard UI library.
