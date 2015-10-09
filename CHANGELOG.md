# 1.0 (2015-10-09)
## New feature
- Compatible with Akeneo 1.4

## BC Breaks
- All occurrences of addCategory have been replaced by classify, including AddCategory and add_category
- The setCategory functionality has been replaced by the new unclassify rule
- Change services prefix from "pimee_automatic_classification" to "pimee_classification_rule"

## BC Breaks relative to Akeneo 1.4
- Use "Akeneo\Component\Classification\Repository\CategoryRepositoryInterface" instead of "Pim\Bundle\CatalogBundle\Repository\CategoryRepositoryInterface"
- Use "Pim\Component\Catalog\Updater\ProductTemplateUpdaterInterface" instead of "Pim\Bundle\CatalogBundle\Updater\ProductTemplateUpdaterInterface"
- Use "Akeneo\Component\StorageUtils\Updater\PropertyCopierInterface" and "Akeneo\Component\StorageUtils\Updater\PropertySetterInterface" instead of "Pim\Bundle\CatalogBundle\Updater\ProductUpdaterInterface"
  
# 0.1 (2015-07-22)
- Initial release
