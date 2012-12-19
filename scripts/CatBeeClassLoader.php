<?php

class CatBeeClassLoader
{
    private $modelClasses;
    private $componentClasses;

    private static $loader;

    private function loadClasses($dir, &$loadTo)
    {
        $ffs = scandir($dir);
        foreach($ffs as $ff)
        {
            if($ff != '.' && $ff != '..'){
                if(is_dir($dir.'/'.$ff))
                {
                    $this->loadClasses($dir.'/'.$ff, $loadTo);
                }
                else
                {
                    //array_push($arr, $ff);
                    $loadTo[basename($ff, '.php')] = $dir.'/'.$ff;
                }
            }
        }
    }

    private function register($name, $belongsTo)
    {
        if (array_key_exists($name, $belongsTo))
        {
            include_once($belongsTo[$name]);
            return true;
        }
        return false;
    }

    public static function createLoader($catBeeDirBase)
    {
        $loader = new CatBeeClassLoader();
        $loader->modelClasses = array();
        $loader->componentClasses = array();

        $loader->loadClasses($catBeeDirBase.'/model', $loader->modelClasses);
        $loader->loadClasses($catBeeDirBase.'/components', $loader->componentClasses);

        CatBeeClassLoader::$loader = $loader;
    }


    public static function registerModel($model)
    {
        return CatBeeClassLoader::$loader->register($model, CatBeeClassLoader::$loader->modelClasses);
    }

    public static function registerComponent($comp)
    {
        return CatBeeClassLoader::$loader->register($comp, CatBeeClassLoader::$loader->componentClasses);
    }

    public static function registerClass($class)
    {
        if (!CatBeeClassLoader::registerModel($class))
        {
            CatBeeClassLoader::registerComponent($class);
        }

    }

    public static function dump()
    {
        var_dump(CatBeeClassLoader::$loader->modelClasses);
        var_dump(CatBeeClassLoader::$loader->componentClasses);
    }
}
