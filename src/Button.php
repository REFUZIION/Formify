<?php
declare(strict_types=1);

namespace Formify;

use DOMDocument;
use DOMElement;
use DOMException;
use Exception;

class Button
{
    private string $text;
    private string $type;
    private string $style;
    private string $name;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->text = $attributes['text'] ?? 'Submit';
        $this->type = $attributes['type'] ?? 'submit';
        $this->style = $attributes['class'] ?? '';
        $this->name = $attributes['name'] ?? '';
    }

    /**
     * @param string $text
     * @return Button
     */
    public function text(string $text): Button
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param string $type
     * @return Button
     */
    public function type(string $type): Button
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $style
     * @return Button
     */
    public function style(string $style): Button
    {
        $this->style = $style;
        return $this;
    }

    /**
     * @param string $name
     * @return Button
     */
    public function name(string $name): Button
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return DOMElement|null
     */
    public function render(): ?DOMElement
    {
        try {
            $doc = new DOMDocument();
            $button_elm = $doc->createElement('button', $this->text);

            $attributes = [
                'type' => $this->type,
                'name' => $this->name,
                'class' => $this->style,
            ];

            foreach ($attributes as $name => $value) {
                if (empty($value)) {
                    continue;
                }
                $button_elm->setAttribute($name, $value);
            }

            $doc->appendChild($button_elm);
            return $doc->documentElement;
        }
        catch (DOMException|Exception $e) {
            echo sprintf(
                'An error occurred while rendering the button: %s',
                $e->getMessage()
            );
            return null;
        }
    }
}
