<?php

namespace Dada\AutoClassHelper\Services;

use Symfony\Component\Finder\Finder;

class File
{
    public function getFileByFormat(string $path, string $format): array
    {
        $files = $this->getAllFiles($path);

        return array_filter($files,
            fn ($file) => $file->getExtension() === $format);
    }

    public function getAllFiles(string $path): array
    {
        $finder = Finder::create();

        $finder->in($path)->size('<= 1mi')->depth(0);

        return iterator_to_array($finder);
    }
}
