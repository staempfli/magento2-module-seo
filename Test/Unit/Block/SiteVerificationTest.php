<?php
declare (strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Block;

use Staempfli\Seo\Block\SiteVerification;

/**
 * @coversDefaultClass \Staempfli\Seo\Block\SiteVerification
 */
final class SiteVerificationTest extends AbstractBlockSetup
{
    /**
     * @var SiteVerification
     */
    private $block;

    public function setUp()
    {
        parent::setUp();
        $this->block = new SiteVerification(
            $this->context,
            $this->config,
            $this->propertyInterface,
            []);
    }

    public function testGetMetaData()
    {
        $this->assertSame('', $this->block->getMetaData());
    }
}
