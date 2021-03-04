<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper;

use FireBender\Laravel\Dumper\Actions\GetClassParents;
use FireBender\Laravel\Dumper\Actions\GetClassInterfaces;
use FireBender\Laravel\Dumper\Actions\GetClassTraits;
use FireBender\Laravel\Dumper\Actions\GetClassProperties;
use FireBender\Laravel\Dumper\Actions\GetClassMethods;

use Reflection, ReflectionClass, ReflectionFunction;
use Artisan;
use Exception;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Route;

class Dumper
{
	/**
	 * 
	 */
	protected static $_instance;

	protected $return = [];

	/**
	 * 
	 */
	public function dump(Object $object)
	{
		$class = new ReflectionClass($object);

		$this->return[] = $class->getName();
		$this->return[] = '';
		
		$this->parents($object);
		$this->interfaces($object);
		$this->traits($object);
		$this->properties($object);
		$this->methods($object);

		dd($this->return);
	}

	/**
	 * 
	 */
	protected function parents(Object $object)
	{
		$parents = GetClassParents::run($object);

		$this->return[] = 'Parents';
		$this->return[] = '';
		$this->return = array_merge($this->return, array_values($parents));
		$this->return[] = '';
	}

	/**
	 * 
	 */
	protected function interfaces(Object $object)
	{
		$interfaces = GetClassInterfaces::run($object);

		$this->return[] = 'Interfaces';
		$this->return[] = '';
		$this->return = array_merge($this->return, $interfaces);
		$this->return[] = '';
	}

	/**
	 * 
	 */
	protected function traits(Object $object)
	{
		$traits = GetClassTraits::run($object);

		$this->return[] = 'Traits';
		$this->return[] = '';
		$this->return = array_merge($this->return, array_values($traits));
		$this->return[] = '';
	}

	/**
	 * 
	 */
	protected function properties(Object $object)
	{
		$properties = GetClassProperties::run($object);

		$this->return[] = 'Properties';
		$this->return[] = '';
		$this->return = array_merge($this->return, array_values($properties));
		$this->return[] = '';
	}

	/**
	 * 
	 */
	protected function methods(Object $object)
	{
		$methods = GetClassMethods::run($object);

		$this->return[] = 'Methods';
		$this->return[] = '';
		$this->return = array_merge($this->return, array_values($methods));
	}

	/**
	 * 
	 */
	public static function getDump($value)
	{
		$type = gettype($value);

		if ($type === 'object') return get_class($value);

		if ($type === 'array') $value = self::stringifyClosureInArray($value);

        $cloner = new VarCloner();
        $dumper = new CliDumper();

        $data = $cloner->cloneVar($value);

        $output = $dumper->dump($data, true);

        $output = str_replace(PHP_EOL, '', $output);

        // remove array:\d+
        $pattern = '|array:\d+\s|';
        $output = preg_replace($pattern, '', $output);

        // remove extra space after []
        $pattern = '|\[\s+|';
        $output = preg_replace($pattern, '[', $output);

        $pattern = '|\s{2}|';
        $output = preg_replace($pattern, ', ', $output);

        return $output;
	}

	/**
	 * Closures in arrays return too much info
	 * Turn closures into string before passing to symfony/var-dumper
	 */
	public static function stringifyClosureInArray($array)
	{
		foreach ($array as $k => $v)
		{
			if (is_object($v))
			{
				$class = new ReflectionClass($v);
				$name = $class->getName();
				if ($name === 'Closure')
				{
					$arr = [];
					$function = new ReflectionFunction($v);
					$params = $function->getParameters();
					foreach ($params as $param)
					{
						$entry = '';

						if ($param->hasType())
						{
							$type = $param->getType();
							$entry .= $type->getName() . ' ';
						}

						$entry .= $param->getName();

						if ($param->isDefaultValueAvailable())
						{
							if ($param->isDefaultValueConstant())
							{
								$entry .= ' = ' . $param->getDefaultValueConstantName();
								continue;
							}

							$defaultValue = $param->getDefaultValue();
							$dumped = $this->getDump($defaultValue);
							$entry .= ' = ' . $dumped;
						}

						$arr[] = $entry;

						$array[$k] = 'Closure (' . implode(', ', $arr) . ')';
					}
				}
			}
		}

		return $array;
	}

	/**
	 * 
	 */
	public function bindings($return = false)
	{
		$bindings = app()->getBindings();
		$keys = array_keys($bindings);
		sort($keys);

		if ($return) return $keys;

		dd($keys);
	}

	/**
	 * 
	 */
	public function providers($return = false)
	{
		$arr = app()->getLoadedProviders();
		$providers = array_keys($arr);
		sort($providers);

		if ($return) return $providers;

		dd($providers);
	}

	/**
	 * 
	 */
	public function commands($return = false)
	{
		$all = Artisan::all();
		$commands = array_keys($all);
		sort($commands);
		
		if ($return) return $commands;

		dd($commands);
	}

	/**
	 * 
	 */
	public function routes($return = false) 
	{
        $routes = Route::getRoutes()->getRoutes();

        $unnamed = 0;
        $arr = [];
        foreach ($routes as $route) {
            $name = $route->getName();

            if ($name === null) {
            	$unnamed++;
            	$name = 'Route # ' . $unnamed;
            }

            $actionName = $route->getActionName();

            $uri = $route->uri;

            $arr[$name] = ['action' => $actionName, 'uri' => $uri];
        }
        ksort($arr);
        
        if ($return) return $arr;

        dd($arr);
	}

	/**
	 * 
	 */
	protected function __construct()
	{
	}

	/**
	 * 
	 */
	public static function getInstance(...$args)
	{
		if (null === self::$_instance) 
		{
            self::$_instance = new self();
        }

        if (func_num_args() == 0) {
	        return self::$_instance;	
        }

        (Dumper::getInstance())->dump(...$args);
    }

	/**
     * Enforce singleton; disallow cloning
     *
     * @return void
     */
    private function __clone()
    {
    }


}