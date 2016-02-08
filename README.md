# ClassificationRuleBundle

A bundle that extend the Pim Enterprise CatalogRuleBundle, adding the possibility to classify/unclassify products.


## Requirements

| ClassificationRuleBundle | Akeneo PIM Enterprise Edition |
|:------------------------:|:-----------------------------:|
| v0.1.*                   | v1.3.*                        |
| v1.0.*                   | v1.4.*                        |


## Installation

You can install the bundle with composer:

    $ php composer.phar require akeneo-labs/classification-rule-bundle:1.0.*

If you want to use the development version (only for test purpose, do not use it in production), replace `1.0.*` by `dev-master` in the previous command.

Enable the bundle in the `app/AppKernel.php` file, in the `getPimEnterpriseBundles` function:

    return[
        // ...
        new PimEnterprise\Bundle\ClassificationRuleBundle\PimEnterpriseClassificationRuleBundle(),
    ];


## Rule definition

This bundle is an extension of the CatalogRuleBundle, so it uses the same conditions, and add a new set of actions:

* `classify`: add a product to a category,
* `unclassify`: add a product to a category and remove it from all other category.
If you set the category code to `null`, it will declassify the product.
You can also define a tree to declassify only the product's categories of this tree.

The category must exists, or the rule will not apply.

### Examples

    rules:
        camera_add_canon_brand_category:
            conditions:
                - field:    family.code
                  operator: IN
                  value:
                    - camcorders
                - field:    name
                  operator: CONTAINS
                  value:    Canon
            actions:
                - type:         classify
                  categoryCode: category_canon
        player_set_philips_brand_category:
            conditions:
                - field:    family.code
                  operator: IN
                  value:
                    - camcorders
                    - mp3_players
                - field:    name
                  operator: CONTAINS
                  value:    Philips
            actions:
                - type:         unclassify
        mug_remove_oro_brand_category:
            conditions:
                - field:    family.code
                  operator: IN
                  value:
                    - mugs
                - field:    name
                  operator: CONTAINS
                  value:    Oro
            actions:
                - type:         unclassify
                  treeCode: null
        led_tvs_remove_category_on_master_tree:
            conditions:
                - field:    family.code
                  operator: IN
                  value:
                    - led_tvs
            actions:
                - type:     unclassify
                  treeCode: master


Take a look to [icecat_demo_dev rule fixtures](https://github.com/akeneo/pim-enterprise-dev/blob/1.3/src/PimEnterprise/Bundle/InstallerBundle/Resources/fixtures/icecat_demo_dev/rules.yml) to see more examples of conditions.
