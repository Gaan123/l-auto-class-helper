<?php

namespace Dada\AutoClassHelper;

use BadMethodCallException;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\ParserFactory;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class AutoClassHelper
{
private string $basePathAbstractClass;

private string $basePathConcreteClass;
//    public function __construct(private readonly string $basePathAbstractClass,private readonly string $basePathConcreteClass)
//    {
////        dd($this->app)
//    }

    public static function __callStatic($method, $args)
    {
        if (method_exists(get_called_class(), $method)) {
            $obj = new static();

            return call_user_func_array(
                [$obj, $method],
                $args
            );
        }
        throw new BadMethodCallException();
    }

    public function __call($method, $args)
    {
        if (method_exists(get_called_class(), $method)) {
            return call_user_func_array(
                [$this, $method],
                $args
            );
        }
        throw new BadMethodCallException();
    }

    protected function bindClass(string $basePathAbstractClass, string $basePathConcreteClass, array $extra = []): bool
    {
        $this->basePathConcreteClass = $basePathConcreteClass;
        $this->basePathAbstractClass = $basePathAbstractClass;
        $abstractClasses = $this->getClasses($basePathAbstractClass);
        $concreteClasses = $this->getClasses($basePathConcreteClass);
        if (! count($abstractClasses) && ! count($concreteClasses)) {
        return false;
        }

        $except = $extra['except'] ?? [];
        $dynBind = $extra['dynBind'] ?? [];
        $abstractClasses = array_diff($abstractClasses, [...$except, ...array_column($dynBind, 'abstract')]);
        $this->simpleBind($abstractClasses);
        if (count($dynBind)) {
        $this->dynamicBind($dynBind);
        }

        return true;
    }

    private function simpleBind($abstractClasses, $singleton = true)
    {
        foreach ($abstractClasses as $abstractClass) {
            $baseAbstractNamespace = ucfirst(Str::camel(basename($this->basePathAbstractClass)));
            $baseConcreteNamespace = ucfirst(Str::camel(basename($this->basePathConcreteClass)));
            $concreteClass = str_replace(search: $baseAbstractNamespace, replace: $baseConcreteNamespace, subject: $abstractClass);
            if (class_exists($abstractClass) && class_exists($concreteClass)) {
                if ($singleton) {
                    app()->singleton($abstractClass, $concreteClass);

                    continue;
                }
                app()->bind($abstractClass, $concreteClass);
            }
        }
    }

    private function dynamicBind($dynamicClasses)
    {
        foreach ($dynamicClasses as $dynamicClass) {
            extract($dynamicClass);
            if (isset($abstract) && isset($concrete) &&
                (class_exists($abstract) || interface_exists($abstract)) && class_exists($concrete)) {
                $args = $args ?? [];
                if ($singleton ?? true) {
                    app()->singleton($abstract, function () use ($concrete, $args) {
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

    protected function getAllFiles(string $path): array
    {
        $finder = Finder::create();

        $finder
            ->in($path)
            ->size('<= 1mi')
            ->depth(0)
            ->contains('~^\s*((?:namespace)\s+(\w+);)?\s*(?:abstract\s+|final\s+)?(?:class|interface)\s+(\w+)~mi');

        return iterator_to_array($finder);
    }

//    protected function getBaseFolder(string $path):string
//    {
//        explode('/',$path);
//    }

    protected function getFileByFormat(string $path, string $format): array
    {
        $files = $this->getAllFiles($path);

        return array_filter($files, fn ($file) => $file->getExtension() === $format);
    }

    protected function getClasses(string $path): array
    {
        // Loop through the tokens to find the namespace declaration
        $finder = Finder::create();
        $finder
            ->in($path)
            ->size('<= 2mi')
            ->filter(fn ($file) => $file->getExtension() === 'php')
            ->contains('~^\s*((?:namespace)\s+(\w+);)?\s*(?:abstract\s+|final\s+)?(?:class|interface)\s+(\w+)~mi');
        $classes = [];
        foreach ($finder as $file) {
            if ($this->getNameSpaceFromFile($file)) {
            $classes[] = $this->getNameSpaceFromFile($file).'\\'.str_replace('/', '\\', explode('.', $file->getRelativePathname()))[0];
            }
        }

        return $classes;
    }

    /**
     * @return string
     */
    protected function getNameSpaceFromFile(SplFileInfo $file): string|bool
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

            $contents = file_get_contents($file->getPathname());

                $stmts = $parser->parse($contents);
                foreach ($stmts as $stmt) {
                    if ($stmt instanceof Namespace_) {
                        return $stmt->name->toString();
                    }
                }

                return false;

    }
}
