<?php
declare (strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Controller\Index;

use Magento\Framework\App\Action\Context;
use Staempfli\Seo\Model\Robots;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Robots
     */
    private $robots;

    public function __construct(
        Robots $robots,
        Context $context
    ) {
        parent::__construct($context);
        $this->robots = $robots;
    }

    public function execute()
    {
        $result = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_RAW);
        $result->setHeader('Content-Type', 'text/plain')->setContents(
            $this->robots->getContent()
        );
        return $result;
    }
}
