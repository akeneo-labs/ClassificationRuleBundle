<?php

namespace PimEnterprise\Bundle\ClassificationRuleBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Automatic classification bundle
 *
 * @author    Damien Carcel <damien.carcel@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class PimEnterpriseClassificationRuleBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'PimEnterpriseCatalogRuleBundle';
    }
}
