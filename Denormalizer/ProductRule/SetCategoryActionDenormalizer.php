<?php

namespace PimEnterprise\Bundle\ClassificationRuleBundle\Denormalizer\ProductRule;

use PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductSetCategoryActionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Denormalize product set category rule actions.
 *
 * @author    Damien Carcel <damien.carcel@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
