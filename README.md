Integrating Magmi into Magento import
=====================================

Given you have Magento and a Magmi installed you want to leverage the 
comfort of importing product from Magento admin and the performance of 
Magmi import.

# Requirements

* Magento (http://www.magentocommerce.com/download)
* Magmi (http://sourceforge.net/projects/magmi)

# Dataflow profile

To use the integration you will have to create a dataflow advanced profile
with at least the adapter paramether set to 
magmiimport/convert_adapter_product

For example:

~~~ xml
<action type="magmiimport/convert_parser_magmi" method="parse" />
~~~
