<?php

namespace PimEnterprise\Bundle\AutomaticClassificationBundle\Denormalizer\ProductRule;

use PimEnterprise\Bundle\AutomaticClassificationBundle\Model\ProductSetCategoryActionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Denormalize product set category rule actions.
 *
 * @author Damien Carcel (https://github.com/damien-carcel)
 */
class SetCategoryActionDenormalizer implements DenormalizerInterface
{
    /** @var string */
    protected $setActionClass;

    /**
     * @param string $setActionClass
     */
    public function __construct($setActionClass)
    {
        $this->setActionClass = $setActionClass;
    }
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return new $this->setActionClass($data);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === $this->setActionClass &&
            isset($data['type']) &&
            ProductSetCategoryActionInterface::ACTION_TYPE === $data['type'];
    }
}
