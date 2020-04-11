<?php

namespace Kiryi\Pagyi\Model;

class Type implements PropertyInterface
{
    const ALLOWEDVALUES = [
        'normal',
        'left',
        'left no-padding',
        'right',
        'right no-padding',
        'center'
    ];

    private string $type = 'normal';

    public function setProperty($value): void
    {
        if ($this->validateType($value) === true) {
            $this->type = $value;
        }
    }

    public function getProperty(): string
    {
        return $this->type;
    }

    private function validateType(string $value): bool
    {
        if (in_array($value, $this::ALLOWEDVALUES) === true) {
            return true;
        } else {
            return false;
        }
    }
}
