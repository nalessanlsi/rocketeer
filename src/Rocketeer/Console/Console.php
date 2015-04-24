<?php

/*
 * This file is part of Rocketeer
 *
 * (c) Maxime Fabre <ehtnam6@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Rocketeer\Console;

use Illuminate\Console\Application;
use Rocketeer\Rocketeer;

/**
 * A standalone Rocketeer CLI.
 *
 * @author Maxime Fabre <ehtnam6@gmail.com>
 */
class Console extends Application
{
    /**
     * Display the application's help.
     *
     * @return string
     */
    public function getHelp()
    {
        $help  = str_replace($this->getLongVersion(), null, parent::getHelp());
        $state = $this->buildBlock('Current state', $this->getCurrentState());
        $help  = sprintf('%s'.PHP_EOL.PHP_EOL.'%s%s', $this->getLongVersion(), $state, $help);

        return $help;
    }

    /**
     * @return string
     */
    public function getLongVersion()
    {
        $version = Rocketeer::COMMIT === '@commit@' ? '(dev version)' : Rocketeer::COMMIT;

        return sprintf(
            '<info>%s</info> <comment>%s</comment>',
            $this->getName(),
            $version
        );
    }

    /**
     * Build an help block.
     *
     * @param string   $title
     * @param string[] $informations
     *
     * @return string
     */
    protected function buildBlock($title, $informations)
    {
        $message = '<comment>'.$title.'</comment>';
        foreach ($informations as $name => $info) {
            $message .= PHP_EOL.sprintf('  <info>%-15s</info> %s', $name, $info);
        }

        return $message;
    }

    /**
     * Get current state of the CLI.
     *
     * @return string[]
     */
    protected function getCurrentState()
    {
        return [
            'application_name' => realpath($this->laravel['rocketeer.rocketeer']->getApplicationName()),
            'application'      => realpath($this->laravel['rocketeer.paths']->getApplicationPath()),
            'configuration'    => realpath($this->laravel['rocketeer.paths']->getConfigurationPath()),
            'tasks'            => $this->laravel['path.rocketeer.tasks'],
            'events'           => $this->laravel['path.rocketeer.events'],
            'logs'             => $this->laravel['path.rocketeer.logs'],
        ];
    }
}
