<?php

namespace NoLoCo\Core\Process\Node;

/**
 * A Node is one element in a process that performs one action
 * in the process. The node can perform any work using information
 * in the configuration of the node instance, the context passed to
 * the node from the process, or a static action that does not
 * have a configuration or use data in the context.
 *
 * There are three categories of nodes:
 * - flow nodes that returns a response based on information in the
 *   context that route the process to different branches.
 * - data nodes that perform context manipulation activities that add,
 *   remove, modify data stored in the context.
 * - work nodes that do perform work outside the process system
 *
 * Each node has a type which is represented the fully qualified name
 * of the node class. Each node has a key which is unique in its process
 * and is used to navigate the flow of the process.
 *
 * A node is called by the process using the run function that receives
 * the process Context as the sole parameter and returns a ProcessNodeResult
 * object containing information allowing the process to route upon a successful
 * run or error information when a process fails.
 */
interface NodeInterface
{
    /**
     * Set the node key for this instance of the node which is unique in a process.
     * The process edges reference the unique keys of the node to identify the
     * source and target nodes based on the result.
     * @param string $key
     * @return $this
     */
    public function setKey(string $key): static;

    /**
     * Get the unique key for this node instance.
     * @return string
     */
    public function getKey(): string;

    /**
     * Set the configuration for this node instance. The configuration is a
     * 2D array that contains a simple key/value pair. The value of the
     * configuration can be processed before being set by the
     * ConfigurationValueInterface instances
     * @param array $configuration
     * @return $this
     */
    public function setConfiguration(array $configuration): static;

    public function addConfiguration(string $key, mixed $value): static;

    public function mergeConfiguration(array $partialConfiguration): static;


}