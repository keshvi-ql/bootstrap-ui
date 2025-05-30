<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         2.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Console;

use Cake\Console\Exception\ConsoleException;
use SimpleXMLElement;

/**
 * An object to represent a single argument used in the command line.
 * ConsoleOptionParser creates these when you use addArgument()
 *
 * @see \Cake\Console\ConsoleOptionParser::addArgument()
 */
class ConsoleInputArgument
{
    /**
     * Name of the argument.
     *
     * @var string
     */
    protected $_name;

    /**
     * Help string
     *
     * @var string
     */
    protected $_help;

    /**
     * Is this option required?
     *
     * @var bool
     */
    protected $_required;

    /**
     * An array of valid choices for this argument.
     *
     * @var array<string>
     */
    protected $_choices;

    /**
     * Default value for the argument.
     *
     * @var string|null
     */
    protected $_default;

    /**
     * Make a new Input Argument
     *
     * @param array<string, mixed>|string $name The long name of the option, or an array with all the properties.
     * @param string $help The help text for this option
     * @param bool $required Whether this argument is required. Missing required args will trigger exceptions
     * @param array<string> $choices Valid choices for this option.
     * @param string|null $default The default value for this argument.
     */
    public function __construct($name, $help = '', $required = false, $choices = [], $default = null)
    {
        if (is_array($name) && isset($name['name'])) {
            foreach ($name as $key => $value) {
                $this->{'_' . $key} = $value;
            }
        } else {
            /** @psalm-suppress PossiblyInvalidPropertyAssignmentValue */
            $this->_name = $name;
            $this->_help = $help;
            $this->_required = $required;
            $this->_choices = $choices;
            $this->_default = $default;
        }
    }

    /**
     * Get the value of the name attribute.
     *
     * @return string Value of this->_name.
     */
    public function name(): string
    {
        return $this->_name;
    }

    /**
     * Checks if this argument is equal to another argument.
     *
     * @param \Cake\Console\ConsoleInputArgument $argument ConsoleInputArgument to compare to.
     * @return bool
     */
    public function isEqualTo(ConsoleInputArgument $argument): bool
    {
        return $this->name() === $argument->name() &&
            $this->usage() === $argument->usage();
    }

    /**
     * Generate the help for this argument.
     *
     * @param int $width The width to make the name of the option.
     * @return string
     */
    public function help(int $width = 0): string
    {
        $name = $this->_name;
        if (strlen($name) < $width) {
            $name = str_pad($name, $width, ' ');
        }
        $optional = '';
        if (!$this->isRequired()) {
            $optional = ' <comment>(optional)</comment>';
        }
        if ($this->_choices) {
            $optional .= sprintf(' <comment>(choices: %s)</comment>', implode('|', $this->_choices));
        }
        if ($this->_default !== null) {
            $optional .= sprintf(' <comment>default: "%s"</comment>', $this->_default);
        }

        return sprintf('%s%s%s', $name, $this->_help, $optional);
    }

    /**
     * Get the usage value for this argument
     *
     * @return string
     */
    public function usage(): string
    {
        $name = $this->_name;
        if ($this->_choices) {
            $name = implode('|', $this->_choices);
        }
        $name = '<' . $name . '>';
        if (!$this->isRequired()) {
            $name = '[' . $name . ']';
        }

        return $name;
    }

    /**
     * Get the default value for this argument
     *
     * @return string|null
     */
    public function defaultValue()
    {
        return $this->_default;
    }

    /**
     * Check if this argument is a required argument
     *
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->_required;
    }

    /**
     * Check that $value is a valid choice for this argument.
     *
     * @param string $value The choice to validate.
     * @return true
     * @throws \Cake\Console\Exception\ConsoleException
     */
    public function validChoice(string $value): bool
    {
        if (empty($this->_choices)) {
            return true;
        }
        if (!in_array($value, $this->_choices, true)) {
            throw new ConsoleException(
                sprintf(
                    '"%s" is not a valid value for %s. Please use one of "%s"',
                    $value,
                    $this->_name,
                    implode(', ', $this->_choices)
                )
            );
        }

        return true;
    }

    /**
     * Append this arguments XML representation to the passed in SimpleXml object.
     *
     * @param \SimpleXMLElement $parent The parent element.
     * @return \SimpleXMLElement The parent with this argument appended.
     */
    public function xml(SimpleXMLElement $parent): SimpleXMLElement
    {
        $option = $parent->addChild('argument');
        $option->addAttribute('name', $this->_name);
        $option->addAttribute('help', $this->_help);
        $option->addAttribute('required', (string)(int)$this->isRequired());
        $choices = $option->addChild('choices');
        foreach ($this->_choices as $valid) {
            $choices->addChild('choice', $valid);
        }
        if ($this->_default !== null) {
            $option->addAttribute('default', $this->_default);
        }

        return $parent;
    }
}
