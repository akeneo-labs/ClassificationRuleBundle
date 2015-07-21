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
class ProductSetCategoryAction extends AbstractCategoryAction implements ProductSetCategoryActionInterface
{
    /** @var string */
    protected $treeCode;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->treeCode = isset($data['treeCode']) ? $data['treeCode'] : null;
    }


    /**
     * {@inheritdoc}
     */
    public function getTreeCode()
    {
        return $this->treeCode;
    }

    /**
     * {@inheritdoc}
     */
    public function setTreeCode($treeCode)
    {
        $this->treeCode = $treeCode;

        return $this;
    }
}
