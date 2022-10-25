<?php

namespace NoLoCo\Core\Process\Context;

class Context implements ContextInterface
{
    protected $data = [];

    /**
     * @inheritDoc
     */
    public function set(string $key, mixed $value): static
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * @inheritDoc
     */
    public function remove(string $key): static
    {
        $this->data[$key] = null;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function clear(string $key): bool
    {
        if (isset($this->data[$key])) {
            $this->data[$key] = null;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function getInt(string $key): int
    {
        return (int) $this->data[$key];
    }

    /**
     * @inheritDoc
     */
    public function getFloat(string $key): float
    {
        return (float) $this->data[$key];
    }

    /**
     * @inheritDoc
     */
    public function getString(string $key): string
    {
        return (string) $this->data[$key];
    }

    /**
     * @inheritDoc
     */
    public function getArray(string $key): array
    {
        return (array) $this->data[$key];
    }

    /**
     * @inheritDoc
     */
    public function getObject(string $key, string $type): object
    {
        return (object) $this->data[$key];
    }
}