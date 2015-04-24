<?php

namespace Fenrizbes\UploadableBundle\File;

use Symfony\Component\HttpFoundation\File\File;

class UploadableFile extends File
{
    /**
     * Path to the project's root directory
     *
     * @var string
     */
    protected $root_path;

    /**
     * Web path to the file
     *
     * @var string
     */
    protected $web_path;

    public function __construct($root_path, $web_path)
    {
        $this->root_path = $root_path;
        $this->web_path  = $web_path;

        return parent::__construct($root_path . $web_path);
    }

    /**
     * @return string
     */
    public function getRootPath()
    {
        return $this->root_path;
    }

    /**
     * @return string
     */
    public function getWebPath()
    {
        return $this->web_path;
    }
}