<?php

class CatBeeClassLoader
{
    private $modelClasses;
    private $componentClasses;

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

    function __construct($catBeeDirBase)
    {
        $this->modelClasses = array();
        $this->componentClasses = array();

        $this->loadClasses($catBeeDirBase.'/model', $this->modelClasses);
        $this->loadClasses($catBeeDirBase.'/components', $this->componentClasses);
    }


    public function registerModel($model)
    {
        return $this->register($model, $this->modelClasses);
    }

    public function registerComponent($comp)
    {
        return $this->register($comp, $this->componentClasses);
    }

    public function registerModelHierarchy($hierarchy)
    {
        $hierarchyDir = '/'.$hierarchy.'/';
        foreach ($this->modelClasses as $class => $classPath)
        {
            if (strpos($classPath, $hierarchyDir))
            {
                include_once($classPath);
            }
        }
    }

    public function registerComponentHierarchy($hierarchy)
    {
        $hierarchyDir = '/'.$hierarchy.'/';
        foreach ($this->componentClasses as $class => $classPath)
        {
            if (strpos($classPath, $hierarchyDir))
            {
                include_once($classPath);
            }
        }
    }

    public function registerClass($class)
    {
        if (!$this->registerModel($class))
        {
            $this->registerComponent($class);
        }

    }

    public function dump()
    {
        var_dump($this->modelClasses);
        var_dump($this->componentClasses);
    }
}
