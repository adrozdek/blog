<?php

class Template
{
    private $template;
    private $file;
    private $variables;

    public function __construct($file, $tName = 'default')
    {
        $this->template = $tName;
        $this->file = $file;
    }

    public function setVar($name, $value)
    {
        $this->variables[$name] = $value;
    }

    public function output()
    {
        foreach ($this->variables as $key => $value) $$key = $value;
        require_once($this->template . "/" . $this->file);
    }
}