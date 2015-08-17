<?php

namespace PimEnterprise\Bundle\ClassificationRuleBundle\Model;

use Akeneo\Bundle\RuleEngineBundle\Model\ActionInterface;

/**
 * Add action used in product rules.
 * An add action category is used to ad a product in a category.
 *
 * @author    Damien Carcel <damien.carcel@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
interface ProductClassifyActionInterface extends ActionInterface
{
    /** @staticvar string */
    const ACTION_TYPE = 'classify';

    /**
     * @return string
     */
    public function getCategoryCode();

    /**
     * @param string $categoryCode
     *
     * @return ProductClassifyActionInterface
     */
    public function setCategoryCode($categoryCode);
}
