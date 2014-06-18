<?php

class html_writer {

    var $type;
    var $attributes;
    var $voidelements;

    /**
     * Class constructor
     *
     * @param string $type
     * @param array $voidelements
     */
    function __construct($type) {

        $this->type = strtolower($type);
        $this->voidelements = array(
            'area',
            'base',
            'br',
            'col',
            'command',
            'embed',
            'hr',
            'img',
            'input',
            'keygen',
            'link',
            'meta',
            'param',
            'source',
            'track',
            'wbr'
        );
    }

    /**
     * Get a html element attribute value
     *
     * @param type $attribute
     * @return type
     */
    function get($attribute) {

        return $this->attributes[$attribute];
    }

    /**
     * Set a html element attribute
     *
     * @param optional array/string $attribute
     * @param type $value
     */
    function set_attribute($attribute, $value='') {

        if (!is_array($attribute)) {
            $this->attributes[$attribute] = $value;
        } else {
            $this->attributes = array_merge($this->attributes, $attribute);
        }
    }

    function set_attributes($attributes) {

        foreach ($attributes as $attribute => $value) {
            $this->set_attribute($attribute, $value);
        }
    }

    /**
     * Remove a html element attribute
     *
     * @param type $att
     * @return void
     */
    function remove($att) {

        if (isset($this->attributes[$att])) {
            unset($this->attributes[$att]);
        }
    }

    /**
     * Clear all attributes from a html element
     *
     * @return void
     */
    function clear() {

        $this->attributes = array();
    }

    /**
     * Injects content into a non-void element
     *
     * @param string $object
     * @return void
     */
    function inject($object) {

        if (@get_class($object) == __class__) {
            $this->attributes['text'] .= $object->build();
        }
    }

    /**
     * Build a html tag
     *
     * @return string
     */
    function build($type=null) {

        if ($type != 'close') {
            $tag = '<' . $this->type;
            if(count($this->attributes)) {
                foreach($this->attributes as $key => $value) {
                    if ($key != 'text') {
                        $tag .= " {$key}='{$value}'";
                    }
                }
            }
            if (!in_array($this->type, $this->voidelements)) {
                if ($type == 'open') {
                    $tag .= '>';
                } else {
                    $tag .= ">{$this->attributes['text']}</{$this->type}>";
                }
            } else {
                $tag .= '/>';
            }
        } else {
            $tag = '</' . $this->type . '>';
        }

        return $tag;
    }

    /**
     * Output the element
     *
     * @return void
     */
    function output() {

        echo $this->build();
    }

    /**
     * Return HTML link element
     *
     * @param string $url the link URL
     * @param text $content the text for the link
     * @param array() $attributes any attributes for the link
     * @return $string
     */
    function link($url, $content, $attributes=array()) {

        $link = new html_writer('a');
        $link->set_attribute('href', $url);
        $link->set_attribute('text', $content);

        if ($attributes) {
            foreach ($attributes as $key => $value) {
                $link->set_attribute($key, $value);
            }
        }

        return $link->build();
    }

    function div($content, $attributes=array()) {

        $div = new html_writer('div');
        $div->set_attribute('text', $content);
        $div->set_attributes($attributes);

        return $div->build();
    }

    function div_open($attributes=array()) {

        $div = new html_writer('div');
        $div->set_attributes($attributes);

        return $div->build('open');
    }

    function div_close() {

        $div = new html_writer('div');

        return $div->build('close');
    }

    function span($content, $attributes=array()) {

        $span = new html_writer('span');
        $span->set_attribute('text', $content);
        $span->set_attributes($attributes);

        return $span->build();
    }
}

