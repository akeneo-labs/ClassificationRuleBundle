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
interface ProductUnclassifyActionInterface extends ActionInterface
{
    /** @staticvar string */
    const ACTION_TYPE = 'unclassify';

    /**
     * @return string|null
     */
    public function getTreeCode();

    /**
     * @param string $treeCode
     *
     * @return ProductUnclassifyActionInterface
     */
    public function setTreeCode($treeCode);
}
