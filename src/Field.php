<?php
declare(strict_types=1);

namespace Formify;

use DOMDocument;
use DOMElement;
use DOMException;
use Exception;

class Field
{
    private string $name;
    private string $type;
    private string $style;
    private string $value;
    private string $placeholder;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->name = $attributes['name'] ?? '';
        $this->placeholder = $attributes['placeholder'] ?? '';
        $this->type = $attributes['type'] ?? 'text';
        $this->style = $attributes['class'] ?? '';
        $this->value = $attributes['value'] ?? '';
    }

    /**
     * @param string $name
     * @return Field
     */
    public function name(string $name): Field
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $placeholder
     * @return Field
     */
    public function placeholder(string $placeholder): Field
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @param string $type
     * @return Field
     */
    public function type(string $type): Field
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $style
     * @return Field
     */
    public function style(string $style): Field
    {
        $this->style = $style;
        return $this;
    }

    /**
     * @param string $value
     * @return Field
     */
    public function value(string $value): Field
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return DOMElement|null
     */
    public function render(): ?DOMElement
    {
        try {
            $doc = new DOMDocument();
            $input_elm = $doc->createElement('input');

            $attributes = [
                'name' => $this->name,
                'type' => $this->type,
                'class' => $this->style,
                'value' => $this->value,
                'placeholder' => $this->placeholder
            ];

            foreach ($attributes as $name => $value) {
                if (empty($value) === false) {
                    $input_elm->setAttribute($name, $value);
                }
            }

            $doc->appendChild($input_elm);
            return $doc->documentElement;
        }
        catch (DOMException|Exception $e) {
            echo sprintf(
                'An error occurred while rendering the field: %s',
                $e->getMessage()
            );
            return null;
        }
    }
}
