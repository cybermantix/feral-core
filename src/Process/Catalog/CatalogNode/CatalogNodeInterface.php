<?php

namespace Feral\Core\Process\Catalog\CatalogNode;

use Feral\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;

/**
 * A catalog node provides information to the user
 * allowing them to select nodes for a process
 */
interface CatalogNodeInterface
{
    const DEFAULT_GROUP = 'Ungrouped';

    /**
     * The unique key for this catalog node.
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * The node code key which this catalog uses for it's
     * functionality
     *
     * @return string
     */
    public function getNodeCodeKey(): string;

    /**
     * The name of this catalog node.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * The group is a collection similar nodes
     * belong to.
     *
     * @return string
     */
    public function getGroup(): string;

    /**
     * The human description of the catalog node that
     * describes to the user whot the node is used for.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get the configuration that is sent to the
     * node code.
     *
     * @return array
     */
    public function getConfiguration(): array;

    /**
     * Get the descriptions of the configuration avialable.
     *
     * @return ConfigurationDescriptionInterface[]
     */
    public function getConfigurationDescriptions(): array;
}
