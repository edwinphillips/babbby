<?php

// Modified from http://davidwalsh.name/create-html-elements-php-htmlelement-class

class html_tag {

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
        $this->voidelements = array('area',
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
                                    'wbr');
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
    function set($attribute, $value='') {

        if (!is_array($attribute)) {
            $this->attributes[$attribute] = $value;
        } else {
            $this->attributes = array_merge($this->attributes, $attribute);
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
    function build() {

        $tag = '<' . $this->type;

        if(count($this->attributes)) {
            foreach($this->attributes as $key => $value) {
                if ($key != 'text') {
                    $tag .= " {$key}='{$value}'";
                }
            }
        }

        if (!in_array($this->type, $this->voidelements)) {
            $tag .= ">{$this->attributes['text']}</{$this->type}>";
        } else {
            $tag .= '/>';
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
}

