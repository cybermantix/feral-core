<?php

namespace Feral\Core\Utility\Filesystem;

use function filesize;
use function is_file;
use function is_readable;

/**
 * This wrapper class manages the basic file operations. This
 * will allow PHPUnit to create mocks for calling classes.
 */
class FileWrapper
{
    /**
     * Check a filepath and and confirm a file exists.
     * @param string $filePath
     * @return bool
     */
    public function isFile(string $filePath): bool
    {
        return is_file($filePath);
    }

    /**
     * Check if a file is readable.
     * @param string $filePath
     * @return bool
     */
    public function isReadable(string $filePath): bool
    {
        return is_readable($filePath);
    }

    /**
     * Check if a file is writable
     * @param string $filePath
     * @return bool
     */
    public function isWritable(string $filePath): bool
    {
        return is_writable($filePath);
    }

    /**
     * Check the size of a file.
     * @param string $filePath
     * @return bool
     */
    public function getFilesize(string $filePath): int
    {
        return filesize($filePath);
    }

    /**
     * Get the contents of a file.
     * @param string $filePath
     * @return bool
     */
    public function getFileContents(string $filePath): string
    {
        return file_get_contents($filePath);
    }
}