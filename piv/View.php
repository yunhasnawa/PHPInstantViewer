<?php


namespace piv;


class View
{
    private $_template;
    private $_data;

    public function __construct($template)
    {
        $this->_template = $template;

        $this->_data = array();
    }

    public function render()
    {
        foreach ($this->_data as $key => $value)
            $$key = $value;

        include "{$this->_template}";
    }

    public function setData(array $data)
    {
        $this->_data = $data;
    }
}