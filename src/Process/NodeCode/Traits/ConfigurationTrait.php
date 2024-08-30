<?php

namespace Feral\Core\Process\NodeCode\Traits;

use Feral\Core\Process\Configuration\ConfigurationManager;
use Feral\Core\Process\NodeCode\NodeCodeInterface;

trait ConfigurationTrait
{
    protected ConfigurationManager $manager;

    /**
     * @see NodeCodeInterface::addConfiguration()
     */
    public function addConfiguration(array $configurationValues): static
    {
        $this->manager->merge($configurationValues);
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
