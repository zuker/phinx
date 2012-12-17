<?php

require_once 'phing/Task.php';
/*require_once 'phing/tasks/ext/phpcpd/PHPCPDFormatterElement.php';*/

/**
 * Runs Phinx DB Migrations.
 *
 * @package phing.tasks.ext.phinx
 * @author  Rob Morgan <robbym@gmail.com>
 * @version $Id$
 */
class PhinxTask extends Task
{
    /**
     * The path to the Phinx configuration file.
     *
     * @var string
     */
    protected $_configuration;

    /**
     * The Phinx environment.
     *
     * @var string
     */
    protected $_environment;

    /**
     * The Phinx command to run.
     *
     * Defaults to 'migrate'.
     *
     * @var string
     */
    protected $_command = 'migrate';

    /**
     * The target version to migrate to.
     *
     * @var float
     */
    protected $_target = 0;

    /**
     * Set the path to the Phinx configuration file.
     *
     * @param string $configuration The configuration file path
     * @return void
     */
    public function setConfiguration($configuration)
    {
        $this->_configuration = $configuration;
    }

    /**
     * Get the path to the Phinx configuration file.
     *
     * @return string
     */
    public function getConfiguration()
    {
        return $this->_configuration;
    }

    /**
     * Sets the specified environment to run Phinx migrations.
     *
     * @param string $environment The specified environment
     * @return void
     */
    public function setEnvironment($environment)
    {
        $this->_environment = $environment;
    }

    /**
     * Gets the specified environment to run Phinx migrations.
     *
     * @return string
     */
    public function getEnvironment()
    {
        return $this->_environment;
    }

    /**
     * Sets the specified Phinx command to execute.
     *
     * Can either be 'migrate' or 'rollback'.
     *
     * @param string $command Command to execute.
     * @return void
     */
    public function setCommand($command)
    {
        $this->_command = $command;
    }

    /**
     * Gets the specified Phinx command to execute.
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->_command;
    }

    /**
     * Sets the target version to migrate to.
     *
     * @param float $target
     * @return void
     */
    public function setTarget($target)
    {
        $this->_target = $target;
    }

    /**
     * Gets the target version to migrate to.
     *
     * @return float
     */
    public function getTarget()
    {
        return $this->_target;
    }

    /**
     * Executes Phinx.
     *
     * @throws BuildException - if the Phinx classes can't be loaded.
     * @return void
     */
    public function main()
    {
        /**
         * Determine Phinx installation
         */

        // TODO - implement
        echo $this->getConfiguration() . PHP_EOL;
        echo $this->getEnvironment() . PHP_EOL;
        echo $this->getCommand() . PHP_EOL;
        echo $this->getTarget() . PHP_EOL;
    }
}