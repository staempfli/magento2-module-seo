<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Model;

class Property implements PropertyInterface
{
    const DEFAULT_PROPERTIES = [];
    const DEFAULT_PREFIX = '';
    const DEFAULT_ATTRIBUTE_NAME = 'name';
    /**
     * @var array
     */
    private $properties = self::DEFAULT_PROPERTIES;
    /**
     * @var string
     */
    protected $prefix = self::DEFAULT_PREFIX;
    /**
     * @var string
     */
    protected $attributeName = self::DEFAULT_ATTRIBUTE_NAME;
    /**
     * @var array
     */
    protected $validImageFormats = [
        'jpg',
        'jpeg',
        'webp',
        'gif',
        'png'
    ];

    /**
     * @param string $prefix
     * @return $this
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @param string $attributeName
     * @return $this
     */
    public function setMetaAttributeName(string $attributeName)
    {
        $this->attributeName = $attributeName;
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        return $this->addProperty('title', strip_tags($title));
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        return $this->addProperty('description', htmlentities(strip_tags($description)));
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
            return $this->addProperty('url', $url);
        }
        throw new \LogicException(
            sprintf('Not a valid URL: [%s]',
                $url
            )
        );
    }

    /**
     * @param string $image
     * @return $this
     */
    public function setImage(string $image)
    {
        $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        if (in_array($extension, $this->validImageFormats)) {
            return $this->addProperty('image', $image);
        }
        throw new \LogicException(
            sprintf('Invalid image format provided: [%s], please use on of these [%s]',
                $extension,
                implode(',', $this->validImageFormats))
        );
    }

    /**
     * @param string $imageAlt
     * @return $this
     */
    public function setImageAlt(string $imageAlt)
    {
        return $this->addProperty('image:alt', htmlentities(strip_tags($imageAlt)));
    }

    /**
     * @param string $key
     * @param string|array $value
     * @return $this
     */
    public function addProperty(string $key, $value)
    {
        $this->properties[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getProperty(string $key)
    {
        return $this->properties[$key] ?? '';
    }

    /**
     * @param string $key
     * @return $this
     */
    public function removeProperty(string $key)
    {
        unset($this->properties[$key]);
        return $this;
    }

    public function toHtml() : string
    {
        $html = $this->renderProperties($this->properties);
        $this->reset();
        return $html;
    }

    public function hasData() : bool
    {
        if ($this->properties) {
            return true;
        }
        return false;
    }

    private function renderProperties(array $properties) : string
    {
        $html = [];
        foreach ($properties as $property => $value) {
            if (is_array($value)) {
                $subList = $this->renderProperties($value);
                $html[] = $subList;
            } else {
                if (empty($value)) {
                    continue;
                }
                $html[] = $this->getMetaTag($property, $value);
            }
        }
        return implode($html);
    }

    private function getMetaTag(string $key, string $value) : string
    {
        return sprintf('<meta %s="%s%s" content="%s" />%s',
            $this->attributeName,
            $this->prefix,
            strip_tags($key),
            strip_tags($value),
            PHP_EOL
        );
    }

    private function reset()
    {
        $this->properties = self::DEFAULT_PROPERTIES;
        $this->prefix = self::DEFAULT_PREFIX;
        $this->attributeName = self::DEFAULT_ATTRIBUTE_NAME;
    }
}
