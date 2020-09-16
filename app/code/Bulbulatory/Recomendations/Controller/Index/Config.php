<?php

namespace Bulbulatory\Recomendations\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Config extends Action
{
    /**
     * @var \Bulbulatory\Recomendations\Helper\Config
     */
    protected $helperData;

    public function __construct(
        Context $context,
        \Bulbulatory\Recomendations\Helper\Config $helperData
    )
    {
        $this->helperData = $helperData;

        return parent::__construct($context);
    }

    public function execute()
    {
        echo $this->helperData->isEnabled();
        exit();
    }
}
