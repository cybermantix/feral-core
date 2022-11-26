<?php

namespace NoLoCo\Core\Process\NodeCode;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
use NoLoCo\Core\Process\Result\ResultInterface;

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
 * the process Data as the sole parameter and returns a ProcessNodeResult
 * object containing information allowing the process to route upon a successful
 * run or error information when a process fails.
 */
interface NodeCodeInterface
{
    /**
     * Get the unique key for this node instance. This key must be unique in the system
     * amongst other Node Code.
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * The human-readable name for this Node Code. This name is shown in any catalog
     * building tools which can modify the configuration and make unique nodes in the
     * catalog.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * The human friendly context about this node code which is used to describe
     * the code and process used by the NodeCode.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * The category this NodeCode belongs to. This helps the admin organize the process
     * algorithms with similar traits and responses.
     *
     * @return string
     */
    public function getCategoryKey(): string;

    /**
     * The array of node code configuration descriptions
     *
     * @return ConfigurationDescriptionInterface[]
     */
    public function getConfigurationDescriptions(): array;

    /**
     * Add an key/value (associative array) of keys and values to the configuration.
     *
     * @param  array $keysValues
     * @return $this
     */
    public function addConfiguration(array $keysValues): static;

    /**
     * @param  ContextInterface $context
     * @return ResultInterface
     */
    public function process(ContextInterface $context): ResultInterface;
}
