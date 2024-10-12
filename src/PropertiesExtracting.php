<?php

namespace Mappify\Mapper;

 /**
  * this class for extracting result from reflection
  *
  * ex result from ReflectionClass :
  * ```
  * array(2) {
  * [0] =>
  *     class ReflectionProperty#66 (2) {
  *         public string $name =>
  *             string(8) "username"
  *         public string $class =>
  *             string(19) "Mappify\Mapper\User"
  *     }
  * }
  * ```
  *
  * @author hadissihaslam.in@gmail.com
  * @version beta 0.2
 */

class PropertiesExtracting
{
    private array $propertiesClass;

    /**
     * @throws \ReflectionException
     */
    public function getPropertiesClass(string $class): array
    {
        $reflection = new \ReflectionClass($class);
        $resultProp = $reflection->getProperties();

        // getting name of properties
        foreach ($resultProp as $item) {
            $this->propertiesClass[] = $item->getName();
        }

        return $this->propertiesClass;
    }

}