<?php

require_once 'phing/Task.php';
require_once 'phing/tasks/ext/phpcpd/PHPCPDFormatterElement.php';

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
     * @var string
     */
    protected $_command;

    /**
     * The target version to migrate to.
     *
     * @var float
     */
    protected $_target;

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
    }
}