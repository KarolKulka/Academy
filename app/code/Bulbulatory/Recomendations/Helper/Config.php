<?php

namespace Bulbulatory\Recomendations\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    public function isEnabled(?int $storeId = null): bool
    {
        return (bool) $this->scopeConfig->getValue(
            'recomendations/general/enabled',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
