<?php

require_once 'phing/Task.php';
require_once 'phing/system/io/PhingFile.php';

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
     * The path to Phinx application.
     *
     * @var string
     */
    protected $phinx = 'phinx';

    /**
     * Phinx configuration file.
     *
     * @var PhingFile
     */
    protected $configuration;

    /**
     * The Phinx environment.
     *
     * @var string
     */
    protected $environment;

    /**
     * The Phinx command to run.
     *
     * @var string
     */
    protected $command;

    /**
     * The target version to migrate to.
     *
     * @var integer
     */
    protected $migrateTarget;

    public function __construct()
    {
        $this->commandLine = new Commandline();
    }

    /**
     * Get path to Phinx executable.
     *
     * @return string
     */
    public function getPhinx()
    {
        return $this->phinx;
    }

    /**
     * Set path to phinx application.
     *
     * @param string $phinx
     */
    public function setPhinx($phinx)
    {
        $this->phinx = $phinx;
    }

    /**
     * Get the Phinx environment.
     *
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Set the Phinx environment.
     *
     * @param string $environment
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    /**
     * Get the Phinx command.
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set the phinx command.
     *
     * @param string $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }

    /**
     * Get target version.
     *
     * @return int
     */
    public function getMigrateTarget()
    {
        return $this->migrateTarget;
    }

    /**
     * Set target version
     *
     * @param int $target
     */
    public function setMigrateTarget($target)
    {
        $this->migrateTarget = $target;
    }

    /**
     * Set the path to the Phinx configuration file.
     *
     * @param PhingFile $configuration The configuration file
     * @return void
     */
    public function setConfiguration(PhingFile $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Get Phinx configuration file.
     *
     * @return PhingFile
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Prepare Phinx command line
     *
     * @param string $phinxCommand Phinx command to run, if omited - command defined in task is used
     */
    private function prepareCommandLine($phinxCommand = null)
    {
        $this->commandLine->clearArgs();
        $commandArg = $this->commandLine->createArgument();
        if ($phinxCommand) {
            $commandArg->setValue($phinxCommand);
        } else {
            $commandArg->setValue($this->command);
        }
    }

    /**
     * Set Phinx configuration argument if exists
     */
    private function setConfigurationArg()
    {
        if (isset($this->configuration)) {
            $this->commandLine->createArgument(true)
                ->setValue('--configuration');
            $this->commandLine->createArgument(true)
                ->setFile($this->configuration);
        }
    }

    /**
     * Set Phinx environment argument if exists
     */
    private function setEnvArg()
    {
        if (isset($this->environment)) {
            $this->commandLine->createArgument(true)
                ->setValue('--environment');
            $this->commandLine->createArgument(true)
                ->setValue($this->environment);
        }
    }

    /**
     * Set Phinx arguments
     */
    private function setArgs()
    {
        $this->setConfigurationArg();
        $this->setEnvArg();
    }

    /**
     * Executes Phinx.
     *
     * @throws BuildException - if the Phinx classes can't be loaded.
     * @return void
     */
    public function main()
    {
        $phinxFile = new SplFileInfo($this->phinx);

        if (false === $phinxFile->isFile() || false == $phinxFile->isExecutable()) {
            throw new BuildException(sprintf('Phinx binary not found, path is "%s"', $phinxFile));
        }

        $this->commandLine->setExecutable($this->phinx);

        $this->commandLine->createArgument()
            ->setValue($this->getPhinx());
        $this->commandLine->createArgument()
            ->setValue('--version');

        exec($this->commandLine, $out, $return);

        if ($return == 0 && preg_match('/version ([\d]+\.[\d]+\.[\d]+)/', $out[0], $matches)) {
            if (version_compare($matches[1], '0.1.5', '<')) {
                throw new BuildException("Requires Phinx version >= 0.1.5");
            }
        } else {
            throw new BuildException("Phinx version query failed");
        }

        if (!isset($this->command)) {
            throw new BuildException("Phinx command not set");
        }

        if (isset($this->configuration)) {
            if (!$this->configuration->exists()) {
                throw new BuildException(
                    sprintf('Phinx configuration file does not exists: "%s"', $this->configuration)
                );
            }
        }

        $this->prepareCommandLine('test');
        $this->setArgs();

        $this->log("Testing configuration file");

        passthru($this->commandLine, $return);

        if ($return == 0) {
            $this->prepareCommandLine();
            $this->setArgs();
            if (isset($this->migrateTarget)) {
                $this->commandLine->createArgument(true)
                    ->setValue($this->migrateTarget);
            }
            passthru($this->commandLine, $return);

            if ($return > 0) {
                throw new BuildException("Phinx execution failed");
            }
        } else {
            throw new BuildException("Phinx configuration test failed");
        }


        // TODO - implement
    }
}