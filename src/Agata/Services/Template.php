<?php

namespace Agata\Services;

class Template
{
    private $pathToFile;
    private $data;

    public function __construct($pathToFile, $data)
    {
        $this->pathToFile = $pathToFile;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function render()
    {
        $contents = file_get_contents($this->pathToFile);
        return str_replace(array_keys($this->data), array_values($this->data), $contents);
    }

    /**
     * @return mixed
     */
    public function getPathToFile()
    {
        return $this->pathToFile;
    }

    /**
     * @param mixed $pathToFile
     */
    public function setPathToFile($pathToFile)
    {
        $this->pathToFile = $pathToFile;
    }

}