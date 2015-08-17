<?php

namespace PimEnterprise\Bundle\ClassificationRuleBundle\Engine\ProductRuleApplier;

use Akeneo\Bundle\RuleEngineBundle\Model\RuleInterface;
use Akeneo\Component\StorageUtils\Updater\PropertyCopierInterface;
use Akeneo\Component\StorageUtils\Updater\PropertySetterInterface;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityNotFoundException;
use Pim\Bundle\CatalogBundle\Model\CategoryInterface;
use Pim\Bundle\CatalogBundle\Model\ProductInterface;
use Pim\Bundle\CatalogBundle\Repository\CategoryRepositoryInterface;
use Pim\Component\Catalog\Updater\ProductTemplateUpdaterInterface;
use PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductClassifyActionInterface;
use PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductUnclassifyActionInterface;
use PimEnterprise\Bundle\CatalogRuleBundle\Engine\ProductRuleApplier\ProductsUpdater as BaseProductsUpdater;
use PimEnterprise\Bundle\CatalogRuleBundle\Model\ProductCopyValueActionInterface;
use PimEnterprise\Bundle\CatalogRuleBundle\Model\ProductSetValueActionInterface;

/**
 * Saves products when apply a rule.
 *
 * @author    Damien Carcel <damien.carcel@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ProductsUpdater extends BaseProductsUpdater
{
    /** @var CategoryRepositoryInterface */
    protected $categoryRepository;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        PropertySetterInterface $propertySetter,
        PropertyCopierInterface $propertyCopier,
        ProductTemplateUpdaterInterface $templateUpdater,
        CategoryRepositoryInterface $categoryRepository
    ) {
        parent::__construct($propertySetter, $propertyCopier, $templateUpdater);

        $this->categoryRepository = $categoryRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function updateFromRule(array $products, RuleInterface $rule)
    {
        $actions = $rule->getActions();
        foreach ($actions as $action) {
            if ($action instanceof ProductSetValueActionInterface) {
                $this->applySetAction($products, $action);
            } elseif ($action instanceof ProductCopyValueActionInterface) {
                $this->applyCopyAction($products, $action);
            } elseif ($action instanceof ProductClassifyActionInterface) {
                $this->applyClassifyAction($products, $action);
            } elseif ($action instanceof ProductUnclassifyActionInterface) {
                $this->applyUnclassifyAction($products, $action);
            } else {
                throw new \LogicException(
                    sprintf('The action "%s" is not supported yet.', ClassUtils::getClass($action))
                );
            }
        }
    }

    /**
     * Applies a add category action on a subject set, if this category exists.
     *
     * @param ProductInterface[]                $products
     * @param ProductClassifyActionInterface $action
     *
     * @return ProductsUpdater
     */
    protected function applyClassifyAction(array $products, ProductClassifyActionInterface $action)
    {
        $category = $this->getCategory($action->getCategoryCode());
        foreach ($products as $product) {
            $product->addCategory($category);
        }

        return $this;
    }

    /**
     * Applies a set category action on a subject set, if this category exists.
     *
     * @param ProductInterface[]                $products
     * @param ProductUnclassifyActionInterface $action
     *
     * @return ProductsUpdater
     */
    protected function applyUnclassifyAction(array $products, ProductUnclassifyActionInterface $action)
    {
        $tree = ($action->getTreeCode()) ? $this->getCategory($action->getTreeCode()) : null;

        foreach ($products as $product) {
            // Remove categories (only a tree if asked) from the product
            foreach ($product->getCategories() as $currentCategory) {
                if (null === $tree || $currentCategory->getRoot() === $tree->getId()) {
                    $product->removeCategory($currentCategory);
                }
            }
        }

        return $this;
    }

    /**
     * @param string $categoryCode
     *
     * @return CategoryInterface
     *
     * @throws \Exception
     */
    protected function getCategory($categoryCode)
    {
        $category = $this->categoryRepository->findOneByIdentifier($categoryCode);
        if (null === $category) {
            throw new EntityNotFoundException(
                sprintf(
                    'Impossible to apply rule to on this category cause the category "%s" does not exist',
                    $categoryCode
                )
            );
        }

        return $category;
    }
}
