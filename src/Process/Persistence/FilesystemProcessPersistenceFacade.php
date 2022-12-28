<?php

namespace Nodez\Core\Process\Persistence;

use Feral\Core\Process\Persistence\PersistenceJsonHydrator;
use Feral\Core\Process\Persistence\PersistenceJsonSerializer;
use Feral\Core\Process\Persistence\Entity\V1 as V1;

/**
 * A process persistence facade that writes to the local filesystem. This
 * can only be used a single node or if a shared file system is mounted to
 * the server.
 */
class FilesystemProcessPersistenceFacade implements ProcessPersistenceFacadeInterface
{
    public function __construct(
        private string $directory,
        private PersistenceJsonHydrator $hydrator = new PersistenceJsonHydrator(),
        private PersistenceJsonSerializer $serializer = new PersistenceJsonSerializer()
    ){}

    /**
     * @inheritDoc
     */
    public function list(): array
    {
        /** @var V1\Process[] $processes */
        $processes = [];
        $directoryContent = array_diff(scandir($this->directory), array('..', '.'));
        foreach ($directoryContent as $file) {
            $jsonString = file_get_contents($this->directory . DIRECTORY_SEPARATOR . $file);
            $process = $this->hydrator->hydrate($jsonString);
            $key = $process->getKey();
            $version = $process->getVersion();
            if (!isset($processes[$key]) || $version > $processes[$key]->getVersion()) {
                $processes[$key] = $process;
            }
        }
        return $processes;
    }

    /**
     * @inheritDoc
     */
    public function read(string $key, string $version = self::LATEST): ?V1\Process
    {
        /** @var V1\Process $bestProcess */
        $bestProcess = null;
        $directoryContent = array_diff(scandir($this->directory), array('..', '.'));
        foreach ($directoryContent as $file) {
            $jsonString = file_get_contents($this->directory . DIRECTORY_SEPARATOR . $file);
            $process = $this->hydrator->hydrate($jsonString);
            $processKey = $process->getKey();
            if ($key == $processKey) {
                if ($version == self::LATEST) {
                    if (!isset($process) || $process->getVersion() > $bestProcess->getVersion()) {
                        $bestProcess = $process;
                    }
                } elseif ($version == $process->getVersion()) {
                    return $process;
                }
            }
        }
        return $bestProcess;
    }

    /**
     * @inheritDoc
     */
    public function write(V1\Process $process): V1\Process
    {
        $version = $process->getVersion() + 1;
        $process->setVersion($version);
        $filename = sprintf('feral-%s-%u.json', $process->getKey(), $version);
        $path = $this->directory . DIRECTORY_SEPARATOR . $filename;
        if (is_file($path)) {
            throw new \Exception(sprintf('Process file already exists %s', $filename));
        } elseif (!is_writeable($path)) {
            throw new \Exception(sprintf('File is not writable exists %s', $filename));
        }
        $json = $this->serializer->serialize($process);
        file_put_contents($path, $json);
        return $process;
    }

    /**
     * @inheritDoc
     */
    public function delete(string $key): void
    {
        $directoryContent = array_diff(scandir($this->directory), array('..', '.'));
        foreach ($directoryContent as $file) {
            $path = $this->directory . DIRECTORY_SEPARATOR . $file;
            $jsonString = file_get_contents($path);
            $process = $this->hydrator->hydrate($jsonString);
            if ($process->getKey() == $key) {
                unlink($path);
            }
        }
    }
}