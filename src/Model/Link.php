<?php

namespace Kiryi\Pagyi\Model;

use Kiryi\Pagyi\Helper\Initializer;
use Kiryi\Pathyi\Formatter as Pathyi;

class Link implements PropertyInterface
{
    private ?string $url = null;
    private ?string $text = null;

    public function setProperty($value): void
    {
        if ($this->validateValue($value) === true) {
            if ($this->validateUrl($value) === true) {
                $this->url = $this->setUrl($value->url);
            }

            if ($this->validateText($value) === true) {
                $this->text = $value->text;
            }
        }
    }

    public function getProperty(): ?array
    {
        if ($this->validateValue($this) === true) {
            return get_object_vars($this);
        } else {
            return null;
        }
    }

    private function validateValue(object $value): bool
    {
        if (
            isset($value->url) === true
            && isset($value->text) === true
        ) {
            return true;
        } else {
            return false;
        }
    }

    private function validateUrl(object $value): bool
    {
        if (
            isset($value->url) === true
            && $value != ''
        ) {
            return true;
        } else {
            return false;
        }
    }

    private function validateText(object $value): bool
    {
        if (
            isset($value->text) === true
            && $value != ''
        ) {
            return true;
        } else {
            return false;
        }
    }

    private function setUrl(string $url)
    {
        if (
            substr($url, 0, 7) != 'http://'
            && substr($url, 0, 8) != 'https://'
        ) {
            return Initializer::getInstance()->getBaseUrl() . (new Pathyi())->format($url);
        } else {
            return $url;
        }
    }
}
