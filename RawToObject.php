<?php

namespace App\Libraries\DataMapper;

class RawToObject
{
    private DataMapping $dataMapping;

    public function __construct()
    {
        $this->dataMapping = new DataMapping();
    }

    /**
     * Info :
     * - Its definitely for database result
     * - Pass class name such as {User::class}. If there's a constructor, create
     *   default values in `InstanceClassHelper` for easier usage anywhere.
     * - Optionally, when data between the database and class are different,
     *   pass an option to map fields. For example, if the database uses
     *   `is_toxic` and your class uses `isToxic`, pass option ["isToxic" => "is_toxic"].
     *
     * Note :
     * - Its not configured for complex data, or when duplicate data
     *
     * @param array $raw Raw data from the database.
     * @param string $class Class name to instantiate.
     * @param array|null $option Optional mapping for property names.
     * @return object
     */
    public function getObject(array $raw, $class, array $option = null)
    {
        // get all properties of the class
        $arrPropertiesClass = $this->dataMapping->getPropertiesClass($class);

        // create an instance of class
        $object = new $class();

        // array data from database
        $rawData = $raw;

        // when user pass option, we will change a key from rawData
        if ($option !== null) {

            // value option is array key value, like this
            // ["field name at class"=>"field name at database"]
            // see doc this method
            foreach ($option as $key => $value) {

                // when "field name at database" exist in rawData
                // we will add into rawData
                if (array_key_exists($value, $raw)) {
                    $rawData[$key] = $raw[$value];
                }
            }
        }

        // Set values in the object
        foreach ($rawData as $key => $value) {

            // sample raw data from database is key value
            // [
            //  "id"=>1,
            //  "name"=>"dev"
            // ]
            // so we will seacrh key at arrPropertiesClass
            if (in_array($key, $arrPropertiesClass)) {

                // construct a string setter method and uppercase first letter
                $setter = 'set' . ucfirst($key);

                // check if setter method exists and call it
                if (method_exists($object, $setter)) {
                    // call setter method with value
                    call_user_func([$object, $setter], $value);
                }
            }
        }

        return $object;
    }

}