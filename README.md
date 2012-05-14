# BulkActions for ModelAdmin Module
    
## Maintainer Contact   

 * Jeremy Shipman (Nickname: Jedateach, jeremy@burnbright.co.nz)

## Requirements

 * SS 2.4

## Documentation



## Installation Instructions

Add the module folder to your silverstripe installation directory.

## Usage Overview

Provides improvements to model admin, allowing you to specify actions to perform on entire result set.

To specify available actions for your model, add the following:

...

Once actions have been specified, an "Action" dropdown, and button will show up on search results.
Clicking the button will perform the action slected in the dropdown.

Note about customising: if you want to create a different collection controller class (eg: MyModelAdmin_CollectionController), and also
use the bulk actions features, then your collection controller class will need to extend ModelAdminBulkActions_CollectionController.

## Known issues

