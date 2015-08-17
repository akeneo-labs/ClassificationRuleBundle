<?php

namespace PimEnterprise\Bundle\ClassificationRuleBundle\Denormalizer\ProductRule;

use PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductClassifyActionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Denormalize product classify rule actions.
 *
 * @author    Damien Carcel <damien.carcel@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ClassifyActionDenormalizer implements DenormalizerInterface
{
    /** @var string */
    protected $classify;

    /**
     * @param string $classify
     */
    public function __construct($classify)
    {
        $this->classify = $classify;
    }
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return new $this->classify($data);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === $this->classify &&
            isset($data['type']) &&
            ProductClassifyActionInterface::ACTION_TYPE === $data['type'];
    }
}
