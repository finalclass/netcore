<?php
/**

Copyright (C) Szymon Wygnanski (s@finalclass.net)

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */

namespace NetCore\Xml;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 14.03.12
 * @time: 09:15
 */
class Parser
{
    protected $options = array(
        'file_path' => ''
    );

    /**
     * @var resource
     */
    private $parser = null;

    public function __construct()
    {
        $this->onElementStartListeners = new ListenersArray($this, Event::ELEMENT_START);
        $this->onElementEndListeners = new ListenersArray($this, Event::ELEMENT_END);
        $this->onDataListeners = new listenersArray($this, Event::DATA);
        $this->onProcessingInstructionListeners = new ListenersArray($this, Event::PROCESSING_INSTRUCTION);

    }

    protected function initParser()
    {
        $this->parser = xml_parser_create();
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($this->parser, XML_OPTION_SKIP_WHITE, 1);
        xml_set_processing_instruction_handler($this->parser, array($this, 'onProcessingInstruction'));
        xml_set_default_handler($this->parser, array($this, 'onParseStart'));
        xml_set_element_handler($this->parser,
            array($this, 'onElementStart'),
            array($this, 'onElementEnd'));
        xml_set_character_data_handler($this->parser, array($this, 'onData'));


        /**
         * To powinno zwracać wszystkie bezpośrednie dzieci elementu $stage
         * $stage(' > *')->
         * najlepiej gdyby dopisać klasę \NetBricks\SearchResult która to
         * by służyła do odpalania funkcji na wszystkich znalezionych elementach.
         * Klasa ta musiałaby implementować ComponentAbstract albo jakoś
         * podpowiadać składnie z ComponentAbstract
         *
         * $stage['o_firmie']['*'] // Wszystkie dzieci elementu o_firmie
         * $stage[' > *'] to samo co $stage(' > *');
         *
         * $stage['contact'] //znajdzie wszystkie elementy o type contact? Czy wezmie pierwsze
         * dziecko z doma o tym type? jak lepiej?
         *
         * Zwróci element o tym id:
         * $stage['contact'];
         * Czyli bylo by to to samo co:
         * $stage->contact;
         * Warto? Chyba nie.
         * Lepiej zrobić, że
         * $stage->contact posotawić
         * ale tak:
         * $stage['nb:Contact'] znajdzie wszystki elementy o tym type
         * a w ten sposób:
         * $stage['nb:Contact nb:ContactForm'] zwróci wszystkie formularze kontaktowe jeśli są na jednej ze stron kontaktowych
         *
         * Chyba druga opcja lepsza. Oczywiście trzeba by zachować taki zapis:
         * $stage->contact; //to zwróciło by dziecko o tej nazwie. były by to
         * równoznaczne z wyciągnięciem pierwszego elementu z wyników wyszukiwania:
         * $stage['nb:Contact nb:ContactForm']->submit->setLabel('Zapisz');
         */


    }

    public function parse()
    {
        $file = $this->getFilePath();
        $data = '';
        if (!($fp = fopen($file, "r"))) {
            if (!xml_parse($this->parser, $data, feof($fp))) {
                die(sprintf("XML error: %s at line %d",
                    xml_error_string(xml_get_error_code($this->parser)),
                    xml_get_current_line_number($this->parser)));
            }
        }

        while ($data = fread($fp, 4096)) {
            if (!xml_parse($this->parser, $data, feof($fp))) {
                die(sprintf("XML error: %s at line %d",
                    xml_error_string(xml_get_error_code($this->parser)),
                    xml_get_current_line_number($this->parser)));
            }
        }
        xml_parser_free($this->parser);
    }

    /**
     * @param string $value
     * @return \NBMLParser
     */
    public function setFilePath($value)
    {
        $this->options['file_path'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return (string)@$this->options['file_path'];
    }

    public function onElementStart($parser, $name, $attrs)
    {
        return $this->onElementStartListeners->dispatch(
                            new Event(Event::ELEMENT_START,
                                $parser,
                                $name, //name
                                $attrs, //attrs
                                $this, //target
                                null //instructionTarget
                            ));
    }

    public function onElementEnd($parser, $name)
    {
        return $this->onElementEndListeners->dispatch(
                    new Event(Event::ELEMENT_END,
                        $parser,
                        null, //name
                        null, //attrs
                        $this, //target
                        null //instructionTarget
                    ));
    }

    public function onProcessingInstruction($parser, $target, $data)
    {
        $this->onElementStartListeners->dispatch(
            new Event(Event::PROCESSING_INSTRUCTION,
                $parser,
                null, //name
                $data, //attrs
                $this, //target
                $target //instructionTarget
            ));
    }

    public function onData($parser, $data)
    {
        return $this->onDataListeners->dispatch(
            new Event(Event::PROCESSING_INSTRUCTION,
                $parser,
                null, //name
                $data, //attrs
                $this, //target
                null //instructionTarget
            ));
    }

}
