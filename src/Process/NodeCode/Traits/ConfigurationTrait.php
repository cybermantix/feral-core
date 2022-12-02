<?php

namespace NoLoCo\Core\Process\NodeCode\Traits;

use NoLoCo\Core\Process\Configuration\ConfigurationManager;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;

trait ConfigurationTrait
{
    protected ConfigurationManager $manager;

    /**
     * @see NodeCodeInterface::addConfiguration()
     */
    public function addConfiguration(array $keysValues): static
    {
        $this->manager->merge($keysValues);
        return $this;
    }

    /**
     * A setter for the class to set the manager.
     *
     * @param  ConfigurationManager $manager
     * @return $this
     */
    protected function setConfigurationManager(ConfigurationManager $manager): static
    {
        $this->manager = $manager;
        return $this;
    }
}
