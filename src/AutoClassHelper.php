<?php

namespace Dada\AutoClassHelper;

use BadMethodCallException;
use Dada\AutoClassHelper\Services\ClassHelper;
use Illuminate\Support\Str;

class AutoClassHelper
{
    private string $basePathAbstractClass;

    private string $basePathConcreteClass;

    /**
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        if (method_exists(get_called_class(), $method)) {
            $obj = new static();

            return call_user_func_array([$obj, $method], $args);
        }
        throw new BadMethodCallException();
    }

    /**
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (method_exists(get_called_class(), $method)) {
            return call_user_func_array([$this, $method], $args);
        }
        throw new BadMethodCallException();
    }

    /**
     * @param  array  $extra ['except'=>(array)'skip all class within it','dynBind'=>'give an feature to pass args to dynamic binding']
     *
     * @description dynBind ['abstract'=>'abstract class sting','concrete'=>'concrete class string','singleton'=>(bool)'singleton or 'bind]
     * @description dynBind ['args'=>(array)'arguments in array']
     */
    protected function bindClass(
        string $basePathAbstractClass,
        string $basePathConcreteClass,
        array $extra = []
    ): bool {
        $classHelper = new ClassHelper();
        $this->basePathConcreteClass = $basePathConcreteClass;
        $this->basePathAbstractClass = $basePathAbstractClass;
        $abstractClasses = $classHelper->getClasses($basePathAbstractClass);
        $concreteClasses = $classHelper->getClasses($basePathConcreteClass);
        if (! count($abstractClasses) && ! count($concreteClasses)) {
        return false;
        }

        $except = $extra['except'] ?? [];
        $dynBind = $extra['dynBind'] ?? [];

        $abstractClasses = array_diff($abstractClasses,
            [...$except, ...array_column($dynBind, 'abstract')]);
        $this->simpleBind($abstractClasses);
        if (count($dynBind)) {
            $this->dynamicBind($dynBind);
        }

        return true;
    }

    /**
     * @return void
     */
    private function simpleBind($abstractClasses, $singleton = true)
    {
        foreach ($abstractClasses as $abstractClass) {
            $baseAbstractNamespace
                = ucfirst(Str::camel(basename($this->basePathAbstractClass)));
            $baseConcreteNamespace
                = ucfirst(Str::camel(basename($this->basePathConcreteClass)));
            $concreteClass = str_replace(search: $baseAbstractNamespace,
                replace: $baseConcreteNamespace, subject: $abstractClass);
            if (class_exists($abstractClass) && class_exists($concreteClass)) {
                if ($singleton) {
                    app()->singleton($abstractClass, $concreteClass);

                    continue;
                }
                app()->bind($abstractClass, $concreteClass);
            }
        }
    }

    /**
     * @return void
     */
    private function dynamicBind($dynamicClasses)
    {
        foreach ($dynamicClasses as $dynamicClass) {
            extract($dynamicClass);
            if (isset($abstract) && isset($concrete)
                && (class_exists($abstract)
                    || interface_exists($abstract))
                && class_exists($concrete)
            ) {
                $args = $args ?? [];
                if ($singleton ?? true) {
                    app()->singleton($abstract,
                        function () use ($concrete, $args) {
                            new $concrete(...$args);
                        });

                    continue;
                }
                app()->bind($abstract, function () use ($concrete, $args) {
                    new $concrete(...$args);
                });
            }
        }
    }
}
