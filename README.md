# ClassificationRuleBundle

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/akeneo-labs/ClassificationRuleBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/akeneo-labs/ClassificationRuleBundle/?branch=master)
[![Build Status](https://travis-ci.org/akeneo-labs/ClassificationRuleBundle.svg?branch=master)](https://travis-ci.org/akeneo-labs/ClassificationRuleBundle)

A bundle that extend the Akeneo PIM Enterprise CatalogRuleBundle, adding the possibility to unclassify products from a defined tree.


## Requirements

| ClassificationRuleBundle | Akeneo PIM Enterprise Edition |
|:------------------------:|:-----------------------------:|
| v1.1.*                   | v1.5.*                        |
| v1.0.*                   | v1.4.*                        |
| v0.1.*                   | v1.3.*                        |


## Installation

You can install the bundle with composer:

```bash
    php composer.phar require akeneo-labs/classification-rule-bundle:1.1.*
```

Enable the bundle in the `app/AppKernel.php` file, in the `registerBundles` method:

```php
    $bundles = [
        // ...
        new PimEnterprise\Bundle\ClassificationRuleBundle\PimEnterpriseClassificationRuleBundle(),
    ];
```

Now let's clear your cache, update your database and reinstall your assets:

```bash
    php app/console cache:clear --env=prod
    php app/console pim:installer:assets --env=prod
```

## Documentation

### Rule definition

This bundle is an extension of the CatalogRuleBundle, so it uses the same conditions, and add a new set of actions:

* `unclassify`: remove a product from categories.
If you set the category code to `null`, it will declassify the product.
You can also define a tree to declassify only the product's categories of this tree.

### Examples

```yaml
    rules:
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
                - type:     unclassify

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
                - type:     unclassify
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
```

Take a look to [the rule definition documentation](http://docs.akeneo.com/latest/cookbook/rule/general_information_on_rule_format.html?highlight=rule%20definition) to see more examples of conditions.
