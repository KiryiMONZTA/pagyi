<?php

namespace Kiryi\Pagyi\Model;

class Color implements PropertyInterface
{
    private ?string $font = null;
    private ?string $background = null;

    public function setProperty($value): void
    {
        if ($this->validateValue($value) === true) {
            if ($this->validateFont($value)) {
                $this->font = $value->font;
            }

            if ($this->validateBackground($value)) {
                $this->background = $value->background;
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
            isset($value->font) === true
            || isset($value->background) === true
        ) {
            return true;
        } else {
            return false;
        }
    }

    private function validateFont(object $value): bool
    {
        if (
            isset($value->font) === true
            && $this->validateColorCode($value->font) === true
        ) {
            return true;
        } else {
            return false;
        }
    }

    private function validateBackground(object $value): bool
    {
        if (
            isset($value->background) === true
            && $this->validateColorCode($value->background) === true
        ) {
            return true;
        } else {
            return false;
        }
    }

    private function validateColorCode(string $code): bool
    {
        if (
            preg_match('/#[0-9a-f]*/', $code, $matches) === 1
            && $matches[0] == $code
            && (
                strlen($code) == 4
                || strlen($code) == 7
            )
        ) {
            return true;
        } else {
            return false;
        }
    }


}
