<?php

namespace spec\PimEnterprise\Bundle\ClassificationRuleBundle\Denormalizer\ProductRule;

use PhpSpec\ObjectBehavior;
use PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductClassifyActionInterface;
use PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductUnclassifyActionInterface;
use Prophecy\Argument;

class UnclassifyActionDenormalizerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductUnclassifyAction');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('PimEnterprise\Bundle\ClassificationRuleBundle\Denormalizer\ProductRule\UnclassifyActionDenormalizer');
    }

    function it_implements()
    {
        $this->shouldHaveType('Symfony\Component\Serializer\Normalizer\DenormalizerInterface');
    }

    function it_denormalizes()
    {
        $data['type'] = ProductUnclassifyActionInterface::ACTION_TYPE;

        $this->denormalize($data, 'PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductUnclassifyAction')
            ->shouldHaveType('PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductUnclassifyAction');
    }

    function it_supports_denormalization()
    {
        $data['type'] = ProductUnclassifyActionInterface::ACTION_TYPE;
        $type = 'PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductUnclassifyAction';

        $this->supportsDenormalization($data, $type)->shouldReturn(true);
    }

    function it_does_not_support_denormalization_for_wrong_object()
    {
        $data['type'] = ProductUnclassifyActionInterface::ACTION_TYPE;
        $type = '\PimEnterprise\Bundle\CatalogRuleBundle\Model\ProductCondition';

        $this->supportsDenormalization($data, $type)->shouldReturn(false);
    }

    function it_does_not_support_denormalization_for_wrong_type()
    {
        $data['type'] = ProductClassifyActionInterface::ACTION_TYPE;
        $type = 'PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductUnclassifyAction';

        $this->supportsDenormalization($data, $type)->shouldReturn(false);
    }

    function it_does_not_support_denormalization_for_wrong_object_and_wrong_type()
    {
        $data['type'] = ProductClassifyActionInterface::ACTION_TYPE;
        $type = '\PimEnterprise\Bundle\CatalogRuleBundle\Model\ProductCondition';

        $this->supportsDenormalization($data, $type)->shouldReturn(false);
    }
}
