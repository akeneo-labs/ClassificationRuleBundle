<?php

namespace spec\PimEnterprise\Bundle\ClassificationRuleBundle\ActionApplier;

use Akeneo\Component\Classification\Repository\CategoryRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Pim\Component\Catalog\Model\CategoryInterface;
use Pim\Component\Catalog\Model\ProductInterface;
use PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductUnclassifyActionInterface;

class UnclassifyActionApplierSpec extends ObjectBehavior
{
    function let(CategoryRepositoryInterface $categoryRepository)
    {
        $this->beConstructedWith($categoryRepository);
    }

    function it_is_an_action_applier()
    {
        $this->shouldImplement('Akeneo\Component\RuleEngine\ActionApplier\ActionApplierInterface');
    }

    function it_supports_unclassify_action(ProductUnclassifyActionInterface $action)
    {
        $this->supports($action)->shouldReturn(true);
    }

    function it_only_remove_categories_of_the_defined_tree(
        $categoryRepository,
        ProductUnclassifyActionInterface $action,
        ProductInterface $product,
        CategoryInterface $tree,
        CategoryInterface $category1,
        CategoryInterface $category2
    ) {
        $action->getTreeCode()->willReturn('tree_1');
        $categoryRepository->findOneByIdentifier('tree_1')->willReturn($tree);

        $tree->getId()->willReturn(1);
        $category1->getRoot()->willReturn(1);
        $category2->getRoot()->willReturn(2);

        $product->getCategories()->willReturn([$category1, $category2]);
        $product->removeCategory($category1)->shouldBeCalled();

        $this->applyAction($action, [$product]);
    }

    function it_removes_all_categories_if_no_tree_defined(
        ProductUnclassifyActionInterface $action,
        ProductInterface $product,
        CategoryInterface $category1,
        CategoryInterface $category2
    ) {
        $action->getTreeCode()->willReturn(null);
        $category1->getRoot()->willReturn(1);
        $category2->getRoot()->willReturn(2);

        $product->getCategories()->willReturn([$category1, $category2]);
        $product->removeCategory($category1)->shouldBeCalled();
        $product->removeCategory($category2)->shouldBeCalled();

        $this->applyAction($action, [$product]);
    }

    function it_throws_an_exception_if_the_tree_code_does_not_exist(
        $categoryRepository,
        ProductUnclassifyActionInterface $action
    ) {
        $action->getTreeCode()->willReturn('tree_1');
        $categoryRepository->findOneByIdentifier('tree_1')->willReturn(null);

        $this
            ->shouldThrow('Doctrine\ORM\EntityNotFoundException')
            ->during('applyAction', [$action, []]);
    }
}
