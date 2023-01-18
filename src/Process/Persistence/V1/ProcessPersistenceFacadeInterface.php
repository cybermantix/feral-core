<?php

namespace Feral\Core\Process\Persistence\V1;


use Feral\Core\Process\Persistence\V1\Entity\Process;

/**
 * An interface used to read and write processes. Use the copy on write(COW)
 * methodology to always create a new version. It is assumed the process is
 * validated BEFORE passing the process to the facade.
 */
interface ProcessPersistenceFacadeInterface
{
    /**
     * By default just get the latest version.
     */
    public const LATEST = -1;

    /**
     * Get a list of the latest processes.
     * @return Process[]
     */
    public function list(): array;

    /**
     * Read a full process by it's key and version. If no version
     * is passed in, then get the latest version.
     * @param string $key
     * @param string $version
     * @return Process|null
     */
    public function read(string $key, string $version = self::LATEST): ?Process;

    /**
     * Write the process to the subsystem. Always update the version
     * on every write (COW).
     * @param Process $process
     * @return Process
     */
    public function write(Process $process): Process;

    /**
     * Delete a process from the sub system. Return the latest version
     * that was deleted.
     * @param string $key
     * @return void
     */
    public function delete(string $key): void;
}