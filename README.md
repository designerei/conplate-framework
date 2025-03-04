# conplate-framework

## Commands

Generate safelist based on configured utilities

`console conplate:generate-safelist`

## Features

- Configure tailwind utilties and update dca fields via `conplate.yaml`; automated building of responsive classes and generated safelist file
- Nested content element `layout` with options for flexbox and grid layout
- Extra style field (`headlineStyle`) to define formatting of headlines within content elements
- Spacing field (`spacing`) to define individual spacing for elements
- Articles with options for background (`backgroundColor`), spacing (`containerSpacing`) and width (`containerSize`) 
- Restrict selection of content elements and frontend modules in the backend
- Extended accordion element (`accordion`) and added fields multi selectable multiSelectable; switched javascript handling from handorgel.js to alpinejs (Alpine UI Components)
- Additional content elements
  - Logo element (`logo`)
  - Copyline element (change text globally within page settings) (`copyline`)
  - Divider element (`divider`)
- Extended image element (`image`)
  - Activate responsive mode (width: 100%)
  - Set aspect-ratio for images
  - Configure width of figure element