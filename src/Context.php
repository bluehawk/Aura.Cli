<?php
/**
 * 
 * This file is part of Aura for PHP.
 * 
 * @package Aura.Cli
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 */
namespace Aura\Cli;

use Aura\Cli\Context\Argv;
use Aura\Cli\Context\Env;
use Aura\Cli\Context\Getopt;
use Aura\Cli\Context\GetoptFactory;
use Aura\Cli\Context\Server;

/**
 * 
 * Collection point for information about the command line execution context.
 * 
 * @package Aura.Cli
 * 
 */
class Context
{
    /**
     * 
     * Imported $argv values.
     * 
     * @var Argv
     * 
     */
    protected $argv;

    /**
     * 
     * Imported $_ENV values.
     * 
     * @var Env
     * 
     */
    protected $env;

    /**
     * 
     * A factory for Getopt objects.
     * 
     * @var Getopt
     * 
     */
    protected $getopt_factory;
    
    /**
     * 
     * Imported $_SERVER values.
     * 
     * @var Server
     * 
     */
    protected $server;

    /**
     * 
     * Constructor.
     * 
     * @param Env $env Imported $_ENV values.
     * 
     * @param Server $server Imported $_SERVER values.
     * 
     * @param Argv $argv Imported $argv values.
     * 
     * @param GetoptFactory $getopt_factory A factory for Getopt objects.
     * 
     */
    public function __construct(
        Env $env,
        Server $server,
        Argv $argv,
        GetoptFactory $getopt_factory
    ) {
        $this->env = $env;
        $this->server = $server;
        $this->argv = $argv;
        $this->getopt_factory = $getopt_factory;
    }

    /**
     * 
     * Magic read for property objects.
     * 
     * @param string $key The property to get.
     * 
     * @return mixed A property object.
     * 
     */
    public function __get($key)
    {
        if (in_array($key, array('env', 'server', 'argv'))) {
            return $this->$key;
        }
    }
    
    /**
     * 
     * Returns a new Getopt instance.
     * 
     * @param array $options Option definitions for the Getopt instance.
     * 
     * @return Getopt
     * 
     */
    public function getopt(array $options)
    {
        return $this->getopt_factory->newInstance(
            $this->argv->get(),
            $options
        );
    }
}
