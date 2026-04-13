<?php
declare(strict_types=1);

namespace Formify;

use DOMDocument;
use DOMElement;
use DOMException;
use Exception;

class Fieldset
{
    private string $legend = '';
    /** @var Field[] */
    private array $fields = [];

    /**
     * @param string $text
     * @return Fieldset
     */
    public function legend(string $text): Fieldset
    {
        $this->legend = $text;
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
     * @return DOMElement|null
     */
    public function render(): ?DOMElement
    {
        try {
            $doc = new DOMDocument();
            $fieldset = $doc->createElement('fieldset');

            if (empty($this->legend) === false) {
                $legend = $doc->createElement('legend', $this->legend);
                $fieldset->appendChild($legend);
            }

            foreach ($this->fields as $field) {
                $input = $field->render();
                if ($input === null) {
                    continue;
                }

                $import = $doc->importNode($input, true);
                $fieldset->appendChild($import);
            }

            $doc->appendChild($fieldset);
            return $doc->documentElement;
        }
        catch (DOMException|Exception $e) {
            echo sprintf(
                'An error occurred while rendering the fieldset: %s',
                $e->getMessage()
            );
            return null;
        }
    }
}
