<?php

namespace spec\PimEnterprise\Bundle\ClassificationRuleBundle\Engine\ProductRuleApplier;

use Akeneo\Bundle\RuleEngineBundle\Model\RuleInterface;
use Akeneo\Component\Classification\Repository\CategoryRepositoryInterface;
use Akeneo\Component\StorageUtils\Updater\PropertyCopierInterface;
use Akeneo\Component\StorageUtils\Updater\PropertySetterInterface;
use Doctrine\ORM\EntityNotFoundException;
use PhpSpec\ObjectBehavior;
use Pim\Bundle\CatalogBundle\Model\CategoryInterface;
use Pim\Bundle\CatalogBundle\Model\GroupInterface;
use Pim\Bundle\CatalogBundle\Model\ProductInterface;
use Pim\Bundle\CatalogBundle\Model\ProductTemplateInterface;
use Pim\Component\Catalog\Updater\ProductTemplateUpdaterInterface;
use PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductClassifyActionInterface;
use PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductUnclassifyActionInterface;
use PimEnterprise\Bundle\CatalogRuleBundle\Model\ProductCopyValueActionInterface;
use PimEnterprise\Bundle\CatalogRuleBundle\Model\ProductSetValueActionInterface;
use Prophecy\Argument;

class ProductsUpdaterSpec extends ObjectBehavior
{
    function let(
        CategoryRepositoryInterface $categoryRepository,
        PropertySetterInterface $propertySetter,
        PropertyCopierInterface $propertyCopier,
        ProductTemplateUpdaterInterface $templateUpdater
    ) {
        $this->beConstructedWith(
            $propertySetter,
            $propertyCopier,
            $templateUpdater,
            $categoryRepository
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('PimEnterprise\Bundle\ClassificationRuleBundle\Engine\ProductRuleApplier\ProductsUpdater');
    }

    function it_does_not_update_products_when_no_actions(
        $propertySetter,
        $propertyCopier,
        $templateUpdater,
        RuleInterface $rule,
        ProductInterface $product
    ) {
        $rule->getActions()->willReturn([]);

        $propertySetter->setData(Argument::any())->shouldNotBeCalled();
        $propertyCopier->copyData(Argument::any())->shouldNotBeCalled();

        $product->getVariantGroup()->willReturn(null);
        $templateUpdater->update(Argument::any(), Argument::any())->shouldNotBeCalled();

        $this->update($rule, [$product]);
    }

    function it_updates_product_when_the_rule_has_a_set_action(
        $propertySetter,
        $templateUpdater,
        RuleInterface $rule,
        ProductInterface $product,
        ProductSetValueActionInterface $action
    ) {
        $action->getField()->willReturn('sku');
        $action->getValue()->willReturn('foo');
        $action->getScope()->willReturn('ecommerce');
        $action->getLocale()->willReturn('en_US');
        $rule->getActions()->willReturn([$action]);

        $propertySetter->setData(Argument::any(), 'sku', 'foo', ['locale' => 'en_US', 'scope' => 'ecommerce'])
            ->shouldBeCalled();

        $product->getVariantGroup()->willReturn(null);
        $templateUpdater->update(Argument::any(), Argument::any())
            ->shouldNotBeCalled();

        $this->update($rule, [$product]);
    }

    function it_updates_product_when_the_rule_has_a_copy_action(
        $propertyCopier,
        $templateUpdater,
        RuleInterface $rule,
        ProductInterface $product,
        ProductCopyValueActionInterface $action
    ) {
        $action->getFromField()->willReturn('sku');
        $action->getToField()->willReturn('description');
        $action->getFromLocale()->willReturn('fr_FR');
        $action->getToLocale()->willReturn('fr_CH');
        $action->getFromScope()->willReturn('ecommerce');
        $action->getToScope()->willReturn('tablet');
        $rule->getActions()->willReturn([$action]);

        $propertyCopier->copyData(
            $product,
            $product,
            'sku',
            'description',
            [
                'from_locale' => 'fr_FR',
                'to_locale'   => 'fr_CH',
                'from_scope'  => 'ecommerce',
                'to_scope'    => 'tablet',
            ]
            )->shouldBeCalled();

        $product->getVariantGroup()->willReturn(null);
        $templateUpdater->update(Argument::any(), Argument::any())
            ->shouldNotBeCalled();

        $this->update($rule, [$product]);
    }

    function it_classifies_product_when_the_rule_has_a_classify_action(
        $templateUpdater,
        $categoryRepository,
        CategoryInterface $category,
        RuleInterface $rule,
        ProductInterface $product,
        ProductClassifyActionInterface $action
    ) {
        $rule->getActions()->willReturn([$action]);

        $action->getCategoryCode()->willReturn('categoryCode');
        $categoryRepository->findOneByIdentifier('categoryCode')->willReturn($category);

        $product->addCategory($category)->shouldBeCalled();
        $product->removeCategory(Argument::any())->shouldNotBeCalled();

        $product->getVariantGroup()->willReturn(null);
        $templateUpdater->update(Argument::any(), Argument::any())
            ->shouldNotBeCalled();

        $this->update($rule, [$product]);
    }

    function it_declassifies_product_when_the_rule_has_an_unclassify_action_without_category_code(
        $templateUpdater,
        CategoryInterface $currentCategory,
        RuleInterface $rule,
        ProductInterface $product,
        ProductUnclassifyActionInterface $action
    ) {
        $action->getTreeCode()->willReturn(null);
        $rule->getActions()->willReturn([$action]);

        $product->getCategories()->willReturn([$currentCategory]);
        $product->removeCategory($currentCategory)->shouldBeCalled();
        $product->addCategory(Argument::any())->shouldNotBeCalled();

        $product->getVariantGroup()->willReturn(null);
        $templateUpdater->update(Argument::any(), Argument::any())
            ->shouldNotBeCalled();

        $this->update($rule, [$product]);
    }

    function it_declassifies_product_on_a_tree_when_the_rule_has_an_unclassify_action_with_tree(
        $templateUpdater,
        $categoryRepository,
        CategoryInterface $currentCategory1,
        CategoryInterface $currentCategory2,
        CategoryInterface $tree,
        RuleInterface $rule,
        ProductInterface $product,
        ProductUnclassifyActionInterface $action
    ) {
        $action->getTreeCode()->willReturn('TreeCode');
        $rule->getActions()->willReturn([$action]);

        $categoryRepository->findOneByIdentifier('TreeCode')->willReturn($tree);
        $tree->getId()->willReturn(1);
        $currentCategory1->getRoot()->willReturn(1);
        $currentCategory2->getRoot()->willReturn(2);

        $product->getCategories()->willReturn([$currentCategory1, $currentCategory2]);
        $product->removeCategory($currentCategory1)->shouldBeCalled();
        $product->removeCategory($currentCategory2)->shouldNotBeCalled();
        $product->addCategory(Argument::any())->shouldNotBeCalled();

        $product->getVariantGroup()->willReturn(null);
        $templateUpdater->update(Argument::any(), Argument::any())
            ->shouldNotBeCalled();

        $this->update($rule, [$product]);
    }

    function it_throws_exception_when_category_code_does_not_exist(
        $categoryRepository,
        RuleInterface $rule,
        ProductClassifyActionInterface $action,
        ProductInterface $product
    ) {
        $rule->getActions()->willReturn([$action]);
        $action->getCategoryCode()->willReturn('UnknownCode');

        $categoryRepository->findOneByIdentifier('UnknownCode')->willReturn(null);

        $this
            ->shouldThrow(
                new EntityNotFoundException(
                    'Impossible to apply rule to on this category cause the category "UnknownCode" does not exist'
                )
            )
            ->during('update', [$rule, [$product]]);
    }

    function it_throws_exception_when_tree_code_does_not_exist(
        $categoryRepository,
        RuleInterface $rule,
        ProductUnclassifyActionInterface $action,
        ProductInterface $product
    ) {
        $rule->getActions()->willReturn([$action]);
        $action->getTreeCode()->willReturn('UnknownCode');

        $categoryRepository->findOneByIdentifier('UnknownCode')->willReturn(null);

        $this
            ->shouldThrow(
                new EntityNotFoundException(
                    'Impossible to apply rule to on this category cause the category "UnknownCode" does not exist'
                )
            )
            ->during('update', [$rule, [$product]]);
    }

    function it_throws_exception_when_update_a_product_with_an_unknown_action(
        RuleInterface $rule,
        ProductInterface $product
    ) {
        $rule->getActions()->willReturn([new \stdClass()]);
        $rule->getCode()->willReturn('test_rule');

        $this->shouldThrow(new \LogicException('The action "stdClass" is not supported yet.'))
            ->during('update', [$rule, [$product]]);
    }

    function it_ensures_priority_of_variant_group_values_over_the_rule(
        $propertyCopier,
        $templateUpdater,
        RuleInterface $rule,
        ProductInterface $product,
        ProductCopyValueActionInterface $action,
        GroupInterface $group,
        ProductTemplateInterface $productTemplate
    ) {
        $action->getFromField()->willReturn('sku');
        $action->getToField()->willReturn('description');
        $action->getFromLocale()->willReturn('fr_FR');
        $action->getToLocale()->willReturn('fr_CH');
        $action->getFromScope()->willReturn('ecommerce');
        $action->getToScope()->willReturn('tablet');
        $rule->getActions()->willReturn([$action]);

        $propertyCopier->copyData(
            $product,
            $product,
            'sku',
            'description',
            [
                'from_locale' => 'fr_FR',
                'to_locale'   => 'fr_CH',
                'from_scope'  => 'ecommerce',
                'to_scope'    => 'tablet',
            ]
        )->shouldBeCalled();

        $product->getVariantGroup()->willReturn($group);
        $group->getProductTemplate()->willReturn($productTemplate);
        $templateUpdater->update($productTemplate, [$product])
            ->shouldBeCalled();

        $this->update($rule, [$product]);
    }
}
