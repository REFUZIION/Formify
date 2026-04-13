<?php
declare(strict_types=1);

namespace Formify;

use DOMDocument;
use DOMElement;
use DOMException;
use Exception;

class RadioGroup
{
    private string $name;
    private string $style;
    private array $options;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->name = $attributes['name'] ?? '';
        $this->style = $attributes['class'] ?? '';
        $this->options = $attributes['options'] ?? [];
    }

    /**
     * @param string $name
     * @return RadioGroup
     */
    public function name(string $name): RadioGroup
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $style
     * @return RadioGroup
     */
    public function style(string $style): RadioGroup
    {
        $this->style = $style;
        return $this;
    }

    /**
     * @param array $options
     * @return RadioGroup
     */
    public function options(array $options): RadioGroup
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return DOMElement|null
     */
    public function render(): ?DOMElement
    {
        try {
            $doc = new DOMDocument();
            $container = $doc->createElement('div');

            if (empty($this->style) === false) {
                $container->setAttribute('class', $this->style);
            }

            foreach ($this->options as $value => $labelText) {
                $wrapper = $doc->createElement('div');

                $input = $doc->createElement('input');
                $input->setAttribute('type', 'radio');
                $input->setAttribute('name', $this->name);
                $input->setAttribute('value', (string) $value);
                $input->setAttribute(
                    'id',
                    sprintf('%s_%s', $this->name, $value)
                );

                $label = $doc->createElement('labelText', $labelText);
                $label->setAttribute(
                    'for',
                    sprintf('%s_%s', $this->name, $value)
                );

                $wrapper->appendChild($input);
                $wrapper->appendChild($label);
                $container->appendChild($wrapper);
            }

            $doc->appendChild($container);
            return $doc->documentElement;
        }
        catch (DOMException|Exception $e) {
            echo sprintf(
                'An error occurred while rendering the radio group: %s',
                $e->getMessage()
            );
            return null;
        }
    }
}
