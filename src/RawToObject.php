<?php

namespace Mappify\Mapper;

class RawToObject
{
    private PropertiesExtracting $propertiesExtracting;

    public function __construct()
    {
        $this->propertiesExtracting = new PropertiesExtracting();
    }

    /**
     * this method will create instance from param {$class}
     *
     * Note :
     * - its not support for complex raw data or dependency injection class
     *
     * info :
     * - the class must have a setter method
     * - $raw : is array result from database
     * - $option : when you have aliases query or mismatch of database fields and class fields
     *
     *
     * @psalm-template RealInstanceType of object
     * @psalm-param class-string<RealInstanceType> $class
     * @psalm-return RealInstanceType
     *
     * @param array $raw
     * @param string $class
     * @param array|null $option ["field_classes"=>"field_database"]
     * @throws \ReflectionException
     * @return mixed
     */
    public function getObject(array $raw, string $class, array $option=null):mixed
    {
        // get all properties of the class
        $arrPropertiesClass = $this->propertiesExtracting->getPropertiesClass($class);

        // create instance
        $object = new $class;

        $rawData = $raw;

        // in this line we will search data option from raw
        // and change key from raw with option (field class)
        // ex : raw = ["user_id"=>1]
        // at user classes field name is (id)
        // option param ["id"=>"user_id"]
        // so we change raw to ["id"=>1]
        if ($option !== null) {

            // value option : ["field name at class"=>"field name at database"]
            foreach ($option as $key => $value) {

                // when "field name at database" exist in raw
                // we will change key at raw data with option "field classes"
                if (array_key_exists($value, $raw)) {
                    $rawData[$key] = $raw[$value];
                }
            }
        }

        // this line will inject value to object properties
        // remember raw data is array key value
        foreach ($rawData as $key => $value) {

            // sample raw data from database
            // [
            //  "id"=>1,
            //  "name"=>"dev"
            // ]
            // so we will seacrh key at arrPropertiesClass
            if (in_array($key, $arrPropertiesClass)) {

                // build a string setter method and uppercase first letter
                // sample result = 'set'.Name from arrPropertiesClass name
                $setter = 'set' . ucfirst($key);

                // check if setter method exists and call it
                if (method_exists($object, $setter)) {
                    // set the value properties
                    call_user_func([$object, $setter], $value);
                }
            }
        }

        return  $object;
    }
}