<?php

namespace spec\PimEnterprise\Bundle\ClassificationRuleBundle\Denormalizer\ProductRule;

use PhpSpec\ObjectBehavior;
use PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductAddCategoryActionInterface;
use PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductSetCategoryActionInterface;
use Prophecy\Argument;

class SetCategoryActionDenormalizerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductSetCategoryAction');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('PimEnterprise\Bundle\ClassificationRuleBundle\Denormalizer\ProductRule\SetCategoryActionDenormalizer');
    }

    function it_implements()
    {
        $this->shouldHaveType('Symfony\Component\Serializer\Normalizer\DenormalizerInterface');
    }

    function it_denormalizes()
    {
        $data['type'] = ProductSetCategoryActionInterface::ACTION_TYPE;

        $this->denormalize($data, 'PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductSetCategoryAction')
            ->shouldHaveType('PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductSetCategoryAction');
    }

    function it_supports_denormalization()
    {
        $data['type'] = ProductSetCategoryActionInterface::ACTION_TYPE;
        $type = 'PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductSetCategoryAction';

        $this->supportsDenormalization($data, $type)->shouldReturn(true);
    }

    function it_does_not_support_denormalization_for_wrong_object()
    {
        $data['type'] = ProductSetCategoryActionInterface::ACTION_TYPE;
        $type = '\PimEnterprise\Bundle\CatalogRuleBundle\Model\ProductCondition';

        $this->supportsDenormalization($data, $type)->shouldReturn(false);
    }

    function it_does_not_support_denormalization_for_wrong_type()
    {
        $data['type'] = ProductAddCategoryActionInterface::ACTION_TYPE;
        $type = 'PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductSetCategoryAction';

        $this->supportsDenormalization($data, $type)->shouldReturn(false);
    }

    function it_does_not_support_denormalization_for_wrong_object_and_wrong_type()
    {
        $data['type'] = ProductAddCategoryActionInterface::ACTION_TYPE;
        $type = '\PimEnterprise\Bundle\CatalogRuleBundle\Model\ProductCondition';

        $this->supportsDenormalization($data, $type)->shouldReturn(false);
    }
}
