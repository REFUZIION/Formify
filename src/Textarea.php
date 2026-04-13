<?php
declare(strict_types=1);

namespace Formify;

use DOMDocument;
use DOMElement;
use DOMException;
use Exception;

class Textarea
{
    private string $name;
    private string $style;
    private string $placeholder;
    private int $rows;
    private int $cols;
    private string $content;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->name = $attributes['name'] ?? '';
        $this->style = $attributes['class'] ?? '';
        $this->placeholder = $attributes['placeholder'] ?? '';
        $this->rows = $attributes['rows'] ?? 4;
        $this->cols = $attributes['cols'] ?? 50;
        $this->content = $attributes['content'] ?? '';
    }

    /**
     * @param string $name
     * @return Textarea
     */
    public function name(string $name): Textarea
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $style
     * @return Textarea
     */
    public function style(string $style): Textarea
    {
        $this->style = $style;
        return $this;
    }

    /**
     * @param string $placeholder
     * @return Textarea
     */
    public function placeholder(string $placeholder): Textarea
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @param int $rows
     * @return Textarea
     */
    public function rows(int $rows): Textarea
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * @param int $cols
     * @return Textarea
     */
    public function cols(int $cols): Textarea
    {
        $this->cols = $cols;
        return $this;
    }

    /**
     * @param string $content
     * @return Textarea
     */
    public function content(string $content): Textarea
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return DOMElement|null
     */
    public function render(): ?DOMElement
    {
        try {
            $doc = new DOMDocument();
            $textarea = $doc->createElement('textarea', $this->content);

            $attributes = [
                'name' => $this->name,
                'class' => $this->style,
                'placeholder' => $this->placeholder,
                'rows' => (string) $this->rows,
                'cols' => (string) $this->cols,
            ];

            foreach ($attributes as $name => $value) {
                if (empty($value)) {
                    continue;
                }
                $textarea->setAttribute($name, $value);
            }

            $doc->appendChild($textarea);
            return $doc->documentElement;
        }
        catch (DOMException|Exception $e) {
            echo sprintf(
                'An error occurred while rendering the textarea: %s',
                $e->getMessage()
            );
            return null;
        }
    }
}
