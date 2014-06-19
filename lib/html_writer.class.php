<?php

class html_writer {

    var $type;
    var $attributes;
    var $void;

    /**
     * Class constructor
     *
     * @param string $type
     * @param array $void
     */
    function __construct($type) {

        $this->type = strtolower($type);
        $this->void = array(
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
     *
     * @param array $attributes
     */
    function set_attributes($attributes=array()) {

        foreach ($attributes as $attribute => $value) {
            $this->set_attribute($attribute, $value);
        }
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

    /**
     * Get a html element attribute value
     *
     * @param string $attribute
     * @return string
     */
    function get_attribute($attribute) {

        return $this->attributes[$attribute];
    }

    /**
     * Remove a html element attribute
     *
     * @param string $att
     * @return void
     */
    function remove_attribute($att) {

        if (isset($this->attributes[$att])) {
            unset($this->attributes[$att]);
        }
    }

    /**
     * Clear all attributes from a html element
     *
     * @return void
     */
    function clear_attributes() {

        $this->attributes = array();
    }

    /**
     * Injects content into a non-void element
     *
     * @param string $object
     * @return void
     */
    function inject_content($object) {

        if (@get_class($object) == __class__) {
            $this->attributes['content'] .= $object->build_element();
        }
    }

    /**
     * Build a html tag
     *
     * @return string
     */
    function build_element($type=null) {

        if ($type != 'close') {
            $tag = '<' . $this->type;
            if (count($this->attributes)) {
                foreach ($this->attributes as $key => $value) {
                    if ($key != 'content') {
                        $tag .= " {$key}='{$value}'";
                    }
                }
            }
            if (!in_array($this->type, $this->void)) {
                if ($type == 'open') {
                    $tag .= '>';
                } else {
                    $tag .= ">{$this->attributes['content']}</{$this->type}>";
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
     * Return HTML link element
     *
     * @param string $url the link URL
     * @param text $content the text for the link
     * @param array() $attributes any attributes for the link
     * @return $string
     */
    function link($url, $content, $attributes=array()) {

        $attributes['href'] = $url;
        $attributes['content'] = $content;

        $link = new html_writer('a');
        $link->set_attributes($attributes);

        return $link->build_element();
    }

    /**
     *
     * @param string $content
     * @param array $attributes
     * @return string
     */
    function div($content, $attributes=array()) {

        $attributes['content'] = $content;

        $div = new html_writer('div');
        $div->set_attributes($attributes);

        return $div->build_element();
    }

    /**
     *
     * @param array $attributes
     * @return string
     */
    function div_open($attributes=array()) {

        $div = new html_writer('div');
        $div->set_attributes($attributes);

        return $div->build_element('open');
    }

    /**
     *
     * @return string
     */
    function div_close() {

        $div = new html_writer('div');

        return $div->build_element('close');
    }

    /**
     *
     * @param string $content
     * @param array $attributes
     * @return string
     */
    function span($content, $attributes=array()) {

        $attributes['content'] = $content;

        $span = new html_writer('span');
        $span->set_attributes($attributes);

        return $span->build_element();
    }
}
