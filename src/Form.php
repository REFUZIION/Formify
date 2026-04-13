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
     * @var Field[]
     */
    private array $fields;

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
     * @return Field
     */
    public function field(): Field 
    {
        $field = new Field;
        $this->fields[] = $field;
        return $field;
    }

    /**
     * @return void
     */
    public function render(): void 
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

            foreach ($this->fields as $field) {
                $input = $field->render();
                if ($input === null) {
                    continue;
                }

                $import = $doc->importNode($input, true);
                $html->appendChild($import);
            }

            $doc->appendChild($html);
            echo $doc->saveHTML();
        } 
        catch (\DOMException|\Exception $e) {
            echo sprintf('An error occurred while rendering the form: %s', $e->getMessage());
        }
    }
}
