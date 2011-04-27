<?php

/**
 * Constraint for testing the configuration values
 *
 *
 */
class EcomDev_PHPUnit_Constraint_Config extends PHPUnit_Framework_Constraint
{
    /**
     * Configuration instance
     *
     * @var Varien_Simplexml_Config
     */
    protected $config = null;

    /**
     * Configuration constraint
     *
     * @var PHPUnit_Framework_Constraint
     */
    protected $constraint = null;

    /**
     * Creates configuration constraint for config object
     *
     * @param Varien_Simplexml_Config $config
     */
    public function __construct($constraint)
    {
        $this->config = $config;
        if (!$constraint instanceof EcomDev_PHPUnit_Constraint_Config_Interface) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(
                1, 'EcomDev_PHPUnit_Constraint_Config_Interface'
            );
        }

        $this->constraint = $constraint;
    }


    /**
     *
     * @param mixed   $other
     * @param string  $description
     * @param boolean $not
     */
    public function fail($other, $description, $not)
    {
        $nodeValue = $this->getNodeValue($other);

        return $this->constraint->fail($nodeValue, $description, $not);
    }

    /**
     * Retrives a node value from configuration by child constraint path
     *
     *
     * @param Varien_Simplexml_Config $other
     */
    protected function getNodeValue($config)
    {
        $nodeValue = $config->getNode(
            $this->constraint->getNodePath()
        );

        if ($nodeValue === false) {
            throw new EcomDev_PHPUnit_Constraint_Exception(
                sprintf('Invalid node path specified for evaluation %s', $this->constraint->getNodePath())
            );
        }

        return $nodeValue;
    }

    /**
     * Evalutes constraint that is passed in the parameter
     *
     * @param Varien_Simplexml_Config $config
     * @see PHPUnit_Framework_Constraint::evaluate()
     */
    public function evaluate($config)
    {
        $nodeValue = $this->getNodeValue($config);

        return $this->constraint->evaluate($nodeValue);
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string
     */
    public function toString()
    {
        return $this->constraint->toString();
    }
}
