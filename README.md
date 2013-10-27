Integrating Magmi into Magento import
=====================================

Given you have Magento and a Magmi installed you want to leverage the 
comfort of importing product from Magento admin and the performance of 
Magmi import.

# Requirements

* Magento (http://www.magentocommerce.com/download)
* Magmi (http://sourceforge.net/projects/magmi)

# Installation

Copy contents of app folder into the app folder on your web server 
(extension installation step) and copy contents of folder magmi_files into 
the folder containing your magmi installation (probably magmi).

# Creating advanced dataflow profile

To use the integration you will have to create a dataflow advanced profile
(System => Import/Export => Dataflow - Advance Profiles)
with at least the adapter paramether set to 
magmiimport/convert_adapter_product

For example:

~~~ xml
<action type="magmiimport/convert_parser_magmi" method="parse" />
~~~

# Still in TODO

* demo file for import
* magmi folder name is hardcoded in the code
* check for content errors before import
* fire observers after magmi run
* importing images
* use magento database connection (currently there is no chance w/o modifying magmi)
* use magento dataflow parser
* plugins from magmi?
