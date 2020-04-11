<?php

namespace Kiryi\Pagyi\Model;

use Kiryi\Pagyi\Helper\Initializer;
use Kiryi\Pathyi\Formatter as Pathyi;

class Image implements PropertyInterface
{
    private ?string $file = null;
    private ?string $altText = null;

    public function setProperty($value): void
    {
        if ($this->validateValue($value) === true) {
            if ($this->validateFile($value) === true) {
                $this->file = $this->setFilepath($value->file);
            }

            if ($this->validateAltText($value) === true) {
                $this->altText = $value->altText;
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
        if (isset($value->file) === true) {
            return true;
        } else {
            return false;
        }
    }

    private function validateFile(object $value): bool
    {
        if (
            isset($value->file) === true
            && $value->file != ''
            && file_exists(Initializer::getInstance()->getImgDir() . (new Pathyi())->format($value->file)) === true
        ) {
            return true;
        } else {
            return false;
        }
    }

    private function validateAltText(object $value): bool
    {
        if (
            isset($value->altText) === true
            && $value->altText != ''
        ) {
            return true;
        } else {
            return false;
        }
    }
    
    private function setFilepath(string $file)
    {
        return Initializer::getInstance()->getImgPath() . (new Pathyi())->format($file);
    }
}
