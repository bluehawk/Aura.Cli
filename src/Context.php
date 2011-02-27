<?php
/**
 * 
 * This file is part of the Aura project for PHP.
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 */
namespace aura\cli;

/**
 * 
 * Collection point for information about the command-line execution context.
 * 
 * @package aura.cli
 * 
 */
class Context
{
    /**
     * 
     * Values taken from $_SERVER['argv'].
     * 
     * @var array
     * 
     */
    protected $argv;
    
    /**
     * 
     * Imported $_ENV values.
     * 
     * @var array
     * 
     */
    protected $env;
    
    /**
     * 
     * Imported $_SERVER values.
     * 
     * @var array
     * 
     */
    protected $server;
    
    /**
     * 
     * Constructor.
     * 
     * @return void
     * 
     */
    public function __construct()
    {
        $vars = array('env', 'server');
        foreach ($vars as $key) {
            $this->$key = array();
            $var = '_' . strtoupper($key);
            if (isset($GLOBALS[$var])) {
                $this->$key = $GLOBALS[$var];
            }
        }
        
        $this->setArgv($this->getServer('argv', array()));
    }
    
    /**
     * 
     * Retrieves an **unfiltered** value by key from the $env property, or an 
     * alternate default value if that key does not exist.
     * 
     * @param string $key The $env key to retrieve the value of.
     * 
     * @param string $alt The value to return if the key does not exist.
     * 
     * @return mixed The value of $env[$key], or the alternate default
     * value.
     * 
     */
    public function getEnv($key = null, $alt = null)
    {
        return $this->getValue('env', $key, $alt);
    }
    
    /**
     * 
     * Retrieves an **unfiltered** value by key from the $server property, or
     * an alternate default value if that key does not exist.
     * 
     * @param string $key The $server key to retrieve the value of.
     * 
     * @param string $alt The value to return if the key does not exist.
     * 
     * @return mixed The value of $server[$key], or the alternate default
     * value.
     * 
     */
    public function getServer($key = null, $alt = null)
    {
        return $this->getValue('server', $key, $alt);
    }
    
    public function getArgv($key = null, $alt = null)
    {
        return $this->getValue('argv', $key, $alt);
    }
    
    public function shiftArgv()
    {
        return array_shift($this->argv);
    }
    
    protected function setArgv(array $val)
    {
        $this->argv = $val;
    }
    
    /**
     * 
     * Common method to get a property value and return it.
     * 
     * @param string $var The property variable to fetch from: get, post,
     * etc.
     * 
     * @param string $key The array key in that property, if any, to get the 
     * value of.
     * 
     * @param string $alt The alternative default value to return if the
     * requested key does not exist.
     * 
     * @return mixed The requested value, or the alternative default
     * value.
     * 
     */
    protected function getValue($var, $key, $alt)
    {
        // get the whole property, or just one key?
        if ($key === null) {
            // no key selected, return the whole array
            return $this->$var;
        } elseif (array_key_exists($key, $this->$var)) {
            // found the requested key.
            // need the funny {} becuase $var[$key] will try to find a
            // property named for that element value, not for $var.
            return $this->{$var}[$key];
        } else {
            // requested key does not exist
            return $alt;
        }
    }
}
