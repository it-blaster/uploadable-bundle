<?php

namespace Fenrizbes\UploadableBundle\Form\DataTransformer;

use Fenrizbes\UploadableBundle\File\UploadableFile;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadableDataTransformer implements DataTransformerInterface
{
    protected $root_dir;

    public function __construct($root_dir)
    {
        $this->root_dir = $root_dir;
    }

    public function transform($data)
    {
        if (!is_array($data)) {
            $data = array(
                'file' => $data
            );
        }

        if (!is_null($data['file']) && !$data['file'] instanceof File) {
            $data['file'] = new UploadableFile($this->root_dir, $data['file']);
        }

        return $data;
    }

    public function reverseTransform($data)
    {
        if (!is_array($data) || !isset($data['file']) || !$data['file'] instanceof File) {
            return null;
        }
        
        if ($data['file'] instanceof UploadableFile) {
            return $data['file']->getWebPath();
        }
        
        return $data['file'];
    }
}
