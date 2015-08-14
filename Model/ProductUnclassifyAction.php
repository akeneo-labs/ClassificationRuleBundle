<?php

namespace PimEnterprise\Bundle\ClassificationRuleBundle\Model;

/**
 * Set action used in product rules.
 * An set action category is used to place a product in only one category.
 *
 * @author    Damien Carcel <damien.carcel@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ProductUnclassifyAction implements ProductUnclassifyActionInterface
{
    /** @var string */
    protected $treeCode;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->treeCode = isset($data['treeCode']) ? $data['treeCode'] : null;
    }

    /**
     * Get tree code
     *
     * @return null|string
     */
    public function getTreeCode()
    {
        return $this->treeCode;
    }

    /**
     * Set tree code
     *
     * @param string $treeCode
     *
     * @return $this
     */
    public function setTreeCode($treeCode)
    {
        $this->treeCode = $treeCode;

        return $this;
    }
}
