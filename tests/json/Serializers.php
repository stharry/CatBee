<?php

class ClassPropInfo
{
    public $name;
    public $alias;
    public $isClass;
    public $isDate;
    public $className;
    public $isArray;
    public $writeOnly;
    public $pairedProperty;
    public $pairs;
}


class ClassPropertiesConfig
{
    private $map;

    private function loadMaps($classInfos)
    {
        foreach ($classInfos as $classInfo)
        {

            $classPropInfos = array();

            foreach ($classInfo[ 'fields' ] as $propInfo)
            {
                $classPropInfo            = new ClassPropInfo();
                $classPropInfo->name      = $propInfo[ 'name' ];
                $classPropInfo->alias     = isset($propInfo[ 'alias' ]) ? $propInfo[ 'alias' ] : $classPropInfo->name;
                $classPropInfo->isArray   = isset($propInfo[ 'isArray' ]) ? $propInfo[ 'isArray' ] == '1' : false;
                $classPropInfo->className = isset($propInfo[ 'className' ]) ? $propInfo[ 'className' ] : null;
                if ($classPropInfo->className)
                {
                    if ($classPropInfo->className == "date")
                    {
                        $classPropInfo->isDate = true;
                    }
                    else
                    {
                        $classPropInfo->isClass = true;
                    }
                }
                $classPropInfo->writeOnly = isset($propInfo[ 'writeOnly' ]) ? $propInfo[ 'writeOnly' ] == '1' : false;

                if (isset($propInfo[ 'pair' ]))
                {
                    $classPropInfo->pairedProperty = isset($propInfo[ 'pair' ][ 'name' ]) ? $propInfo[ 'pair' ][ 'name' ] : null;

                    if (isset($propInfo[ 'pair' ][ 'pairs' ]))
                    {
                        $classPropInfo->pairs = $propInfo[ 'pair' ][ 'pairs' ];
                    }
                }


                array_push($classPropInfos, $classPropInfo);
            }
            $this->map[ $classInfo[ 'name' ] ] = $classPropInfos;

        }
    }

    public function LoadClassInfos($configFolder)
    {

        $this->map = array();

        $ffs = scandir($configFolder);

        foreach ($ffs as $ff)
        {

            if ($ff != '.' && $ff != '..')
            {
                if (!is_dir($configFolder . '/' . $ff))
                {
                    $classInfos = json_decode(file_get_contents($configFolder . '/' . $ff), true);
                    $this->loadMaps($classInfos[ 'classes' ]);
                }
            }
        }
    }

    public function getMap()
    {
        return $this->map;
    }
}

interface IClassSerializer
{
    public function deserialize($source, $className);

    public function serialize($source, $className);
}

class ClassSerializer implements IClassSerializer
{
    private $map;

    function __construct($map)
    {
        $this->map = $map;
    }

    private function deserializeProps($source, $className)
    {

        $classInstance = new $className;

        $propInfos = $this->map[ $className ];

        //echo "</p> Props for {$className} : ";var_dump($propInfos);

        foreach ($propInfos as $propInfo)
        {
            $propName = $propInfo->name;
            $propAlias = $propInfo->alias;

            if (!isset($source[ $propAlias ]))
            {
                //echo "</p> Prop value for {$propName} alias {$propAlias} is NULL ";
            }
            else if ($propInfo->isArray)
            {
                $propValsArray = array();
                foreach ($source[ $propAlias ] as $propVal)
                {
                    //echo "</p> array {$propInfo->className} Source: ";var_dump($propVal);

                    $propInArray = $propInfo->isClass
                        ? $this->deserializeProps($propVal, $propInfo->className)
                        : $propVal;

                    array_push($propValsArray, $propInArray);
                }
                $classInstance->$propName = $propValsArray;
            }
            else if ($propInfo->isDate)
            {
                $classInstance->$propName = strtotime($source[ $propAlias ]);
            }
            else if ($propInfo->isClass)
            {
                $classInstance->$propName = $this->deserializeProps($source[ $propAlias ], $propInfo->className);
            }
            else
            {
                //echo "</p> regular {$propName} alias {$propAlias} Source: ";var_dump($source[ $propAlias ]);

                $classInstance->$propName = $source[ $propAlias ];

                if ($propInfo->pairedProperty)
                {
                    $pairVal = array_key_exists($source[ $propAlias ], $propInfo->pairs
                        ? $propInfo->pairs[ $source[ $propAlias ] ]
                        : $propInfo->pairs[ 'default' ]);

                    $pairName                 = $propInfo->pairedProperty;
                    $classInstance->$pairName = $pairVal;
                }
            }
        }

        return $classInstance;
    }

    private function serializeProps($source, $className)
    {
        $result = array();

        $propInfos = $this->map[ $className ];

        foreach ($propInfos as $propInfo)
        {
            $propName = $propInfo->name;
            $propAlias = $propInfo->alias;

            if (!isset($source->$propName))
            {

            }
            else if ($propInfo->isArray)
            {
                $propElems = array();

                foreach ($source->$propName as $propElem)
                {
                    if ($propInfo->isclass)
                    {
                        array_push($propElems, $this->serializeProps($propElem, $propInfo->className));
                    }
                    else
                    {
                        array_push($propElems, $propElem);
                    }
                }
                $result[ $propAlias ] = $propElems;
            }
            else if ($propInfo->isDate)
            {
                $val                 = $source->$propName;
                $result[ $propAlias ] = $val->format('Y-m-d H:i:s');

            }
            else if ($propInfo->isClass)
            {
                //echo "</p> Props for {$propInfo->className} as prop {$propName} : ";var_dump($source->$propName);
                $result[ $propAlias ] = $this->serializeProps($source->$propName, $propInfo->className);

            }
            else
            {

                $result[ $propAlias ] = $source->$propName;
            }
        }

        return $result;
    }

    public function deserialize($source, $className)
    {
        return $this->deserializeProps($source, $className);

    }

    public function serialize($source, $className)
    {
        return $this->serializeProps($source, $className);
    }

}

