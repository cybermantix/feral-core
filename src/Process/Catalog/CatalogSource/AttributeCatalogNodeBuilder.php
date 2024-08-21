<?php

namespace Feral\Core\Process\Catalog\CatalogSource;

use Feral\Core\Process\Catalog\CatalogNode\CatalogNode;
use Feral\Core\Process\Attributes\CatalogNodeDecorator;

/**
 * Convert a Catalog Node Decorator attribute to a CatalogNode.
 */
class AttributeCatalogNodeBuilder
{
    private CatalogNode $subject;
    private array $methodMap = [
        'setKey' => 'getKey',
        'setName' => 'getName',
        'setGroup' => 'getGroup',
        'setDescription' => 'getDescription',
        'setConfiguration' => 'getConfiguration',
        'setConfigurationDescriptions' => 'getConfigurationDescriptions',
    ];

    /**
     * Start the build process by calling the init function
     * @param CatalogNode|null $subject
     * @return $this
     */
    public function init(CatalogNode $subject = null): self
    {
        if ($subject) {
            $this->subject = $subject;
        } else {
            $this->subject = new CatalogNode();
        }
        return $this;
    }

    /**
     * Set the node code key based a factor outside the decorator
     * since the attribute does not carry the node code key
     * @param string $nodeCodeKey
     * @return $this
     */
    public function withNodeCodeKey(string $nodeCodeKey): self
    {
        $this->subject->setNodeCodeKey($nodeCodeKey);
        return $this;
    }

    /**
     * Map the setters in the catalog node to the getters in the
     * decorator.
     * @param CatalogNodeDecorator $decorator
     * @return $this
     */
    public function withCatalogNodeDecorator(CatalogNodeDecorator $decorator): self
    {
        foreach ($this->methodMap as $set => $get) {
            $this->subject->$set($decorator->$get());
        }
        return $this;
    }

    /**
     * Return the built object
     * @return CatalogNode
     */
    public function build(): CatalogNode
    {
        return $this->subject;
    }
}