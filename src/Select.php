<?php
declare(strict_types=1);

namespace Formify;

use DOMDocument;
use DOMElement;
use DOMException;
use Exception;

class Select
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
     * @return Select
     */
    public function name(string $name): Select
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $style
     * @return Select
     */
    public function style(string $style): Select
    {
        $this->style = $style;
        return $this;
    }

    /**
     * @param array $options
     * @return Select
     */
    public function options(array $options): Select
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
            $select = $doc->createElement('select');

            $attributes = [
                'name' => $this->name,
                'class' => $this->style,
            ];

            foreach ($attributes as $name => $value) {
                if (empty($value)) {
                    continue;
                }
                $select->setAttribute($name, $value);
            }

            foreach ($this->options as $value => $label) {
                $option = $doc->createElement('option', $label);
                $option->setAttribute('value', (string) $value);
                $select->appendChild($option);
            }

            $doc->appendChild($select);
            return $doc->documentElement;
        }
        catch (DOMException|Exception $e) {
            echo sprintf(
                'An error occurred while rendering the select: %s',
                $e->getMessage()
            );
            return null;
        }
    }
}
