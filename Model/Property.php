<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Model;

final class Property implements PropertyInterface
{
    const DEFAULT_GROUP = 'default';
    const DEFAULT_PROPERTIES = [];
    const DEFAULT_PREFIX = '';
    const DEFAULT_ATTRIBUTE_NAME = 'name';
    const MAX_DESCRIPTION_LENGTH = 200;

    /**
     * @var array
     */
    private $properties = self::DEFAULT_PROPERTIES;
    /**
     * @var string
     */
    private $prefix = self::DEFAULT_PREFIX;
    /**
     * @var string
     */
    private $attributeName = self::DEFAULT_ATTRIBUTE_NAME;
    /**
     * @var array
     */
    private $validImageFormats = [
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
        return $this->addProperty('title', $this->getFilteredInput($title));
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        $description = $this->getFilteredInput($description);
        if (strlen($description) >= self::MAX_DESCRIPTION_LENGTH) {
            $description = substr($description, 0, (self::MAX_DESCRIPTION_LENGTH - 4)) . ' ...';
        }
        return $this->addProperty(
            'description',
            $description
        );
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
            sprintf(
                'Not a valid URL: [%s]',
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
        $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION)); //@codingStandardsIgnoreLine
        if (in_array($extension, $this->validImageFormats)) {
            return $this->addProperty('image', $image);
        }
        throw new \LogicException(
            sprintf(
                'Invalid image format provided: [%s], please use on of these [%s]',
                $extension,
                implode(
                    ',',
                    $this->validImageFormats
                )
            )
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
     * @param string $group
     * @return string
     */
    public function addProperty(string $key, $value, string $group = self::DEFAULT_GROUP)
    {
        $this->properties[$group][$key] = $value;
        return $this;
    }

    public function getProperty(string $key, string $group = self::DEFAULT_GROUP)
    {
        return $this->properties[$group][$key] ?? '';
    }

    public function removeProperty(string $key, string $group = self::DEFAULT_GROUP)
    {
        unset($this->properties[$group][$key]);
        return $this;
    }

    public function toHtml(string $group = self::DEFAULT_GROUP) : string
    {
        $html = $this->renderProperties($this->properties, $group);
        $this->resetValues($group);
        return $html;
    }

    public function hasData(string $group = self::DEFAULT_GROUP) : bool
    {
        if ($this->properties[$group] ?? false) {
            return true;
        }
        return false;
    }

    private function renderProperties(array $properties, string $group = self::DEFAULT_GROUP) : string
    {
        $html = [];

        if (isset($properties[$group])) {
            $properties = $properties[$group];
        }

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
        return sprintf(
            '<meta %s="%s%s" content="%s" />%s',
            $this->attributeName,
            $this->prefix,
            strip_tags($key),
            strip_tags($value),
            PHP_EOL
        );
    }

    private function getFilteredInput(string $input) : string
    {
        $input = trim(strip_tags(str_replace(["\r\n", "\r", "\n"], "", $input)));
        $input = preg_replace('/\s+/', ' ', $input);
        return htmlentities($input);
    }

    private function resetValues(string $group = self::DEFAULT_GROUP)
    {
        $this->properties[$group] = self::DEFAULT_PROPERTIES;
        $this->prefix = self::DEFAULT_PREFIX;
        $this->attributeName = self::DEFAULT_ATTRIBUTE_NAME;
    }
}
