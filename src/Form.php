<?php
declare(strict_types=1);

namespace Formify;

use DOMDocument;

class Form 
{
    private string $action;
    private string $method;
    private string $enctype;
    /**
     * @var Fieldset[]|Field[]|Textarea[]|Select[]|Button[]|CheckboxGroup[]|RadioGroup[]
     */
    private array $fields;
    private string $csrfToken = '';

    /**
     * @param array $config
     */
    public function __construct(array $config = []) 
    {
        $this->action = $config['action'] ?? '';
        $this->method = isset($config['method']) ? strtoupper($config['method']) : 'POST';
        $this->enctype = $config['enctype'] ?? 'multipart/form-data';
        $this->fields = [];
    }

    /**
     * @param string $token
     * @return self
     */
    public function csrf(string $token): self
    {
        $this->csrfToken = $token;
        return $this;
    }

    /**
     * @return Field
     */
    public function field(): Field 
    {
        $field = new Field;
        $this->fields[] = $field;
        return $field;
    }

    /**
     * @return Textarea
     */
    public function textarea(): Textarea
    {
        $textarea = new Textarea;
        $this->fields[] = $textarea;
        return $textarea;
    }

    /**
     * @return Select
     */
    public function select(): Select
    {
        $select = new Select;
        $this->fields[] = $select;
        return $select;
    }

    /**
     * @param string $text
     * @return Button
     */
    public function button(string $text = 'Submit'): Button
    {
        $button = new Button(['text' => $text]);
        $this->fields[] = $button;
        return $button;
    }

    /**
     * @param string $name
     * @param array $options
     * @return CheckboxGroup
     */
    public function checkbox(string $name, array $options): CheckboxGroup
    {
        $checkbox = new CheckboxGroup(['name' => $name, 'options' => $options]);
        $this->fields[] = $checkbox;
        return $checkbox;
    }

    /**
     * @param string $name
     * @param array $options
     * @return RadioGroup
     */
    public function radio(string $name, array $options): RadioGroup
    {
        $radio = new RadioGroup(['name' => $name, 'options' => $options]);
        $this->fields[] = $radio;
        return $radio;
    }

    /**
     * @return string
     */
    public function toHtml(): string
    {
        try {
            $doc = new DOMDocument();
            $html = $doc->createElement('form');

            $attributes = [
                'action' => $this->action,
                'method' => $this->method,
                'enctype' => $this->enctype
            ];

            foreach ($attributes as $name => $value) {
                $html->setAttribute($name, $value);
            }

            if (empty($this->csrfToken) === false) {
                $csrfInput = $doc->createElement('input');
                $csrfInput->setAttribute('type', 'hidden');
                $csrfInput->setAttribute('name', '_token');
                $csrfInput->setAttribute('value', $this->csrfToken);
                $html->appendChild($csrfInput);
            }

            foreach ($this->fields as $field) {
                $input = $field->render();
                if ($input === null) {
                    continue;
                }

                $import = $doc->importNode($input, true);
                $html->appendChild($import);
            }

            $doc->appendChild($html);
            return $doc->saveHTML();
        }
        catch (\DOMException|\Exception $e) {
            return '';
        }
    }

    /**
     * @return Fieldset
     */
    public function fieldset(): Fieldset
    {
        $fieldset = new Fieldset;
        $this->fields[] = $fieldset;
        return $fieldset;
    }

    /**
     * @return void
     */
    public function render(): void 
    {
        echo $this->toHtml();
    }
}
