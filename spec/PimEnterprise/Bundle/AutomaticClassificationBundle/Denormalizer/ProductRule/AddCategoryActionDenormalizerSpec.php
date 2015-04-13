<?php

namespace spec\PimEnterprise\Bundle\AutomaticClassificationBundle\Denormalizer\ProductRule;

use PhpSpec\ObjectBehavior;
use PimEnterprise\Bundle\AutomaticClassificationBundle\Model\ProductAddCategoryActionInterface;
use PimEnterprise\Bundle\AutomaticClassificationBundle\Model\ProductSetCategoryActionInterface;
use Prophecy\Argument;

class AddCategoryActionDenormalizerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('PimEnterprise\Bundle\AutomaticClassificationBundle\Model\ProductAddCategoryAction');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('PimEnterprise\Bundle\AutomaticClassificationBundle\Denormalizer\ProductRule\AddCategoryActionDenormalizer');
    }

    function it_implements()
    {
        $this->shouldHaveType('Symfony\Component\Serializer\Normalizer\DenormalizerInterface');
    }

    function it_denormalizes()
    {
        $data['type'] = ProductAddCategoryActionInterface::ACTION_TYPE;

        $this->denormalize($data, 'PimEnterprise\Bundle\AutomaticClassificationBundle\Model\ProductAddCategoryAction')
            ->shouldHaveType('PimEnterprise\Bundle\AutomaticClassificationBundle\Model\ProductAddCategoryAction');
    }

    function it_supports_denormalization()
    {
        $data['type'] = ProductAddCategoryActionInterface::ACTION_TYPE;
        $type = 'PimEnterprise\Bundle\AutomaticClassificationBundle\Model\ProductAddCategoryAction';

        $this->supportsDenormalization($data, $type)->shouldReturn(true);
    }

    function it_does_not_support_denormalization_for_wrong_object()
    {
        $data['type'] = ProductAddCategoryActionInterface::ACTION_TYPE;
        $type = '\PimEnterprise\Bundle\CatalogRuleBundle\Model\ProductCondition';

        $this->supportsDenormalization($data, $type)->shouldReturn(false);
    }

    function it_does_not_support_denormalization_for_wrong_type()
    {
        $data['type'] = ProductSetCategoryActionInterface::ACTION_TYPE;
        $type = 'PimEnterprise\Bundle\AutomaticClassificationBundle\Model\ProductAddCategoryAction';

        $this->supportsDenormalization($data, $type)->shouldReturn(false);
    }

    function it_does_not_support_denormalization_for_wrong_object_and_wrong_type()
    {
        $data['type'] = ProductSetCategoryActionInterface::ACTION_TYPE;
        $type = '\PimEnterprise\Bundle\CatalogRuleBundle\Model\ProductCondition';

        $this->supportsDenormalization($data, $type)->shouldReturn(false);
    }
}
