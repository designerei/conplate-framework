# conplate-framework

## Features

- Configure tailwind utilties and update dca fields via `conplate.yaml`; automated building of responsive classes and generated safelist file via `designerei/contao-tailwind-bridge`
- Nested content element `layout` with options for flexbox and grid layout and Spacing field (`spacing`) to define individual spacing for elements via `designerei/contao-layout`
- Extra style field (`headlineStyle`) to define formatting of headlines within content elements
- Articles with options for background (`backgroundColor`), spacing (`containerSpacing`) and width (`containerSize`) 
- Extended accordion element (`accordion`) and added fields multi selectable multiSelectable; switched javascript handling from handorgel.js to alpinejs (Alpine UI Components)
- Additional content elements
  - Divider element (`divider`)
  - Editor elements: Note (`editor_note`) and placeholder (`editor_placeholder`)
- Extended image element (`image`)
  - Activate responsive mode (width: 100%)
  - Set aspect-ratio for images
  - Configure width of figure element