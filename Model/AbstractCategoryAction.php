<?php

namespace PimEnterprise\Bundle\AutomaticClassificationBundle\Model;

/**
 * Add action used in product rules.
 * An add action category is used to add a product in a category.
 *
 * @author    Damien Carcel <damien.carcel@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
abstract class AbstractCategoryAction
{
    /** @var string */
    protected $categoryCode;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->categoryCode = isset($data['categoryCode']) ? $data['categoryCode'] : null;
    }

    /**
     * Get category code.
     *
     * @return null|string
     */
    public function getCategoryCode()
    {
        return $this->categoryCode;
    }

    /**
     * Set category code.
     *
     * @param string $categoryCode
     *
     * @return $this
     */
    public function setCategoryCode($categoryCode)
    {
        $this->categoryCode = $categoryCode;

        return $this;
    }
}
