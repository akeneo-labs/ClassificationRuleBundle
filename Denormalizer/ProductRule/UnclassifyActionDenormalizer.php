<?php

namespace PimEnterprise\Bundle\ClassificationRuleBundle\Denormalizer\ProductRule;

use PimEnterprise\Bundle\ClassificationRuleBundle\Model\ProductUnclassifyActionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Denormalize product unclassify rule actions.
 *
 * @author    Damien Carcel <damien.carcel@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class UnclassifyActionDenormalizer implements DenormalizerInterface
{
    /** @var string */
    protected $unclassify;

    /**
     * @param string $unclassify
     */
    public function __construct($unclassify)
    {
        $this->unclassify = $unclassify;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return new $this->unclassify($data);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === $this->unclassify &&
            isset($data['type']) &&
            ProductUnclassifyActionInterface::ACTION_TYPE === $data['type'];
    }
}
