<?php

namespace PimEnterprise\Bundle\AutomaticClassificationBundle\Denormalizer\ProductRule;

use PimEnterprise\Bundle\AutomaticClassificationBundle\Model\ProductAddCategoryActionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Denormalize product set category rule actions.
 *
 * @author Damien Carcel (https://github.com/damien-carcel)
 */
class AddCategoryActionDenormalizer implements DenormalizerInterface
{
    /** @var string */
    protected $addActionClass;

    /**
     * @param string $addActionClass
     */
    public function __construct($addActionClass)
    {
        $this->addActionClass = $addActionClass;
    }
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return new $this->addActionClass($data);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === $this->addActionClass &&
            isset($data['type']) &&
            ProductAddCategoryActionInterface::ACTION_TYPE === $data['type'];
    }
}
