<?php

namespace Staempfli\Seo\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Page\Config as Subject;

class PageConfigPlugin
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param Subject $subject
     * @param string $elementType
     * @return string[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeGetElementAttributes(Subject $subject, $elementType)
    {
        if ($elementType != Subject::ELEMENT_TYPE_HTML) {
            return [$elementType];
        }
        $subject->setElementAttribute(
            Subject::ELEMENT_TYPE_HTML,
            Subject::HTML_ATTRIBUTE_LANG,
            str_replace('_', '-', $this->getLocaleCode())
        );
        return [$elementType];
    }

    /**
     * @return string
     */
    private function getLocaleCode()
    {
        $localeCode = $this->scopeConfig->getValue('seo/hreflang/locale_code', 'stores')
            ?: $this->scopeConfig->getValue('general/locale/code', 'stores');
        return str_replace('_', '-', strtolower($localeCode));
    }
}
