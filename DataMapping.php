<?php

namespace App\Libraries\DataMapper;

class DataMapping implements Mapping
{
    private array $propertiesClass;
    public function getPropertiesClass($class): array
    {
        $reflection = new \ReflectionClass($class);
        $resultProp = $reflection->getProperties();

        // getting name of properties
        foreach ($resultProp as $item){
            $this->propertiesClass[] = $item->getName();
        }

        return $this->propertiesClass;
    }
}