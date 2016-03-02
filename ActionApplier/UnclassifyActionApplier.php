<?php

namespace PimEnterprise\Bundle\ClassificationRuleBundle\ActionApplier;

use Akeneo\Bundle\RuleEngineBundle\Model\ActionInterface;
use Akeneo\Component\Classification\Repository\CategoryRepositoryInterface;
use Akeneo\Component\RuleEngine\ActionApplier\ActionApplierInterface;
use Doctrine\ORM\EntityNotFoundException;
use Pim\Component\Catalog\Model\CategoryInterface;
use PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductUnclassifyActionInterface;

/**
 * Applies unclassify action
 * Removes categories from a specific tree or the defined categories
 *
 * @author Romain Monceau <romain@akeneo.com>
 */
class UnclassifyActionApplier implements ActionApplierInterface
{
    /** @var CategoryRepositoryInterface */
    protected $categoryRepository;

    /**
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function applyAction(ActionInterface $action, array $products = [])
    {
        $tree = ($action->getTreeCode()) ? $this->getTree($action->getTreeCode()) : null;

        foreach ($products as $product) {
            foreach ($product->getCategories() as $currentCategory) {
                if (null === $tree || $currentCategory->getRoot() === $tree->getId()) {
                    $product->removeCategory($currentCategory);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ActionInterface $action)
    {
        return $action instanceof ProductUnclassifyActionInterface;
    }

    /**
     * Gets a tree from its code
     *
     * @param string $treeCode
     *
     * @return CategoryInterface
     *
     * @throws EntityNotFoundException
     */
    protected function getTree($treeCode)
    {
        $tree = $this->categoryRepository->findOneByIdentifier($treeCode);
        if (null === $tree) {
            throw new EntityNotFoundException(
                sprintf(
                    'Impossible to apply a rule to the category tree "%s", because it does not exist',
                    $treeCode
                )
            );
        }

        return $tree;
    }
}
