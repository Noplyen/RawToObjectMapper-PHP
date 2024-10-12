<?php

namespace Mappify\Mapper;

interface Mapping
{
    public function getPropertiesClass($class):array;
}