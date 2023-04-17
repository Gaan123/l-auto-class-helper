<?php

namespace Dada\AutoClassHelper\Services;

use PhpParser\Node\Stmt\Namespace_;
use PhpParser\ParserFactory;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class ClassHelper
{
    /**
     * @return array with valid classes within given path
     */
    public function getClasses(string $path): array
    {
        // Loop through the tokens to find the namespace declaration
        $finder = Finder::create();
        $finder->in($path)->size('<= 2mi')->filter(fn ($file
        ) => $file->getExtension() === 'php')
            ->contains('~^\s*((?:namespace)\s+(\w+);)?\s*(?:abstract\s+|final\s+)?(?:class|interface)\s+(\w+)~mi');
        $classes = [];
        foreach ($finder as $file) {
            if ($this->getNameSpaceFromFile($file)) {
                $classes[] = $this->getNameSpaceFromFile($file).'\\'
                    .str_replace('/', '\\',
                        explode('.', $file->getRelativePathname()))[0];
            }
        }

        return $classes;
    }

    public function getNameSpaceFromFile(SplFileInfo $file): string|bool
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

    public function getInstanceOfClasses(string $path, string $parentClass): array
    {
       return array_filter($this->getClasses($path), fn ($class) => is_subclass_of($class, $parentClass));
    }
}
