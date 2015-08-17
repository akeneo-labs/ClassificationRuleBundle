<?php

namespace spec\PimEnterprise\Bundle\ClassificationRuleBundle\Model;

use PhpSpec\ObjectBehavior;
use PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductUnclassifyAction;
use Prophecy\Argument;

class ProductUnclassifyActionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            [
                'type' => ProductUnclassifyAction::ACTION_TYPE,
                'categoryCode' => 'categoryCode',
            ]
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductUnclassifyAction');
    }

    function it_is_an_action()
    {
        $this->shouldHaveType('Akeneo\Bundle\RuleEngineBundle\Model\ActionInterface');
    }

    function it_is_a_product_copy_value_action()
    {
        $this->shouldHaveType('PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductUnclassifyActionInterface');
    }

    function it_constructs_a_product_action()
    {
        $this->getCategoryCode()->shouldReturn('categoryCode');
    }
}
