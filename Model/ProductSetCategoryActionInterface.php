<?php

namespace PimEnterprise\Bundle\ClassificationRuleBundle\Model;

use Akeneo\Bundle\RuleEngineBundle\Model\ActionInterface;

/**
 * Set action used in product rules.
 * An set action category is used to place a product in only one category.
 *
 * @author    Damien Carcel <damien.carcel@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
interface ProductSetCategoryActionInterface extends ActionInterface
{
    /** @staticvar string */
    const ACTION_TYPE = 'set_category';

    /**
     * @return string|null
     */
    public function getCategoryCode();

    /**
     * @param string $categoryCode
     *
     * @return ProductSetCategoryActionInterface
     */
    public function setCategoryCode($categoryCode);

    /**
     * @return string|null
     */
    public function getTreeCode();

    /**
     * @param string $treeCode
     *
     * @return ProductSetCategoryActionInterface
     */
    public function setTreeCode($treeCode);
}
