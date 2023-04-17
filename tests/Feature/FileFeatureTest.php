<?php

namespace Dada\AutoClassHelper\Tests\Feature;

use Dada\AutoClassHelper\Facades\File;
use Dada\AutoClassHelper\Tests\TestCase;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;

class FileFeatureTest extends TestCase
{
    public function test_get_all_file_in_directory()
    {
      $files = File::getAllFiles(getcwd().'/devsrc/AbstractClass');
      $this->assertEquals(gettype($files), 'array');
    }

    public function test_handle_wrong_directory()
    {
        $invalidPath = getcwd().'/devsrc/AbstractClss';
        try {
            File::getAllFiles($invalidPath);
        } catch (DirectoryNotFoundException $e) {
            $this->assertInstanceOf(DirectoryNotFoundException::class, $e);
            $this->assertEquals('The "'.$invalidPath.'" directory does not exist.', $e->getMessage());

            return;
        }
        $this->fail('Expected exception not thrown');
    }
}
