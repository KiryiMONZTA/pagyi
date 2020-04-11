<?php

namespace Kiryi\Pagyi\Model;

class Section
{
    private ?Id $id = null;
    private ?Type $type = null;
    private ?Color $color = null;
    private ?Text $text = null;
    private ?Image $image = null;
    private ?Link $link = null;
    
    public function __construct(object $config)
    {
        foreach ($config as $key => $value) {
            $propertyName = 'Kiryi\\Pagyi\\Model\\' . ucfirst($key);
            $this->$key = new $propertyName();
            $this->$key->setProperty($value);
        }

        // Type must be set to default
        if ($this->type === null) {
            $this->type = new Type();
        }
    }
    
    public function getProperties(): array
    {
        $properties = [];

        foreach (get_object_vars($this) as $key => $value) {
            if ($value !== null) {
                $properties[$key] = $value->getProperty();
            } else {
                $properties[$key] = null;
            }
        }

        return $properties;
    }
}
