<?php
namespace AppBundle\Asset\VersionStrategy;

use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;

class ManifestFileVersionStrategy implements VersionStrategyInterface
{
    private $manifestFile;

    private $manifest;

    public function __construct($manifestFile)
    {
        $this->manifestFile = $manifestFile;
    }

    /**
     * Returns the asset version for an asset.
     *
     * @param string $path A path
     *
     * @return string The version string
     */
    public function getVersion($path)
    {
        if ($this->manifest === null) {
            $this->manifest = $this->loadManifest();
        }

        $parts = explode('/', $path);
        list($name, $type) = explode('.', array_pop($parts));

        return isset($this->manifest[$name][$type]) ? $this->manifest[$name][$type] : '';
    }

    /**
     * Applies version to the supplied path.
     *
     * @param string $path A path
     *
     * @return string The versionized path
     */
    public function applyVersion($path)
    {
        $version = $this->getVersion($path);

        if ($version === '') {
            return $path;
        }

        $parts = explode('/', $path);
        array_splice($parts, -1, 1, $version);

        return implode('/', $parts);
    }

    private function loadManifest()
    {
        return json_decode(file_get_contents($this->manifestFile), true);
    }
}
