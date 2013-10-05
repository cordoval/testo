<?php
namespace Testo\Sources;

class FileSource implements SourceInterface
{
    protected $fileTagRegExp = '/^\s*@testo\s+([^\s]+)\s*$/m';

    /**
     * @var RootDirAwareInterface
     */
    protected $rootDirAware;
    public function __construct(RootDirAwareInterface $rootDirAware)
    {
        $this->rootDirAware=$rootDirAware;
    }
    /**
     * @param string $line
     * @return array
     */
    public function getContent($line)
    {
        $placeholders = array();
        if (preg_match($this->fileTagRegExp, $line, $placeholders)) {
            $absolutePathToFile = $this->rootDirAware->getRootDir() . '/' . $placeholders[1];
            if (is_file($absolutePathToFile)) {

                $fileLines = file($absolutePathToFile);
                return $fileLines;
            }
        }

        return false;
    }

}
