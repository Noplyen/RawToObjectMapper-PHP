<?php

namespace App\Libraries\DataMapper;

interface Mapping
{
    public function getPropertiesClass($class):array;
}