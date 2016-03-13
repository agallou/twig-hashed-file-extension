<?php

namespace Agallou\TwigHashedFileExtension;

use Symfony\Component\Finder\Finder;

class Extension extends \Twig_Extension
{
    /**
     * @var string
     */
    protected $directory;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @param string $directory
     * @param string $basePath
     */
    public function __construct($directory, $basePath)
    {
        $this->directory = $directory;
        $this->basePath = $basePath;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('hashed_file', array($this, 'hashedFile')),
        );
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    public function hashedFile($filename)
    {
        $pattern = vsprintf('%s*.%s', array(
            pathinfo($filename, PATHINFO_FILENAME),
            pathinfo($filename, PATHINFO_EXTENSION),
        ));

        $subdir = pathinfo($filename, PATHINFO_DIRNAME);

        return $this->getCompiledFile($pattern, $subdir);
    }

    /**
     * @param string $pattern
     * @param string $subDir
     *
     * @throws \Exception
     *
     * @return string
     */
    protected function getCompiledFile($pattern, $subDir)
    {
        $finder = new Finder();
        $files = $finder->files()->name($pattern)->in($this->directory . '/' . $subDir);

        if (0 === count($files)) {
            throw new \Exception(sprintf("File not found", $pattern));
        }

        if (count($files) > 1) {
            throw new \Exception('There should not have more than one file in the assets dir');
        }

        $compiledFile = null;
        foreach ($files as $file) {
            $compiledFile = $file->getBasename();
        }

        return sprintf('%s/%s/%s', $this->basePath, $subDir, $compiledFile);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'twig_hashed_file';
    }
}
