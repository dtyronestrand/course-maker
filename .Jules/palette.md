## 2024-05-24 - Form Label Association
**Learning:** In standard Vue/HTML forms without special component wrappers, `<label for="...">` requires a matching `id="..."` on the associated input to function correctly. If only the `name` attribute is provided, click-to-focus and screen reader association breaks.
**Action:** Always ensure native input elements explicitly declare an `id` that matches their corresponding label's `for` attribute, especially when copy-pasting or modifying form fields.
