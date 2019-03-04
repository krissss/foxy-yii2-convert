<?php

namespace kriss\foxyYii2Covert;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Util\Filesystem;
use Composer\Util\ProcessExecutor;
use Foxy\Event\GetAssetsEvent;
use Foxy\FoxyEvents;
use Foxy\Json\JsonFile;
use Foxy\Util\AssetUtil;

class Plugin implements PluginInterface, EventSubscriberInterface
{
    protected $composer;
    protected $io;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FoxyEvents::GET_ASSETS => array(
                array('onFoxyGetAssets', 100),
            ),
        );
    }

    public function onFoxyGetAssets(GetAssetsEvent $event)
    {
        $packages = $event->getPackages();
        $assetDir = $event->getAssetDir();
        $fs = new Filesystem(new ProcessExecutor($this->io));
        $filename = 'package.json';

        foreach ($packages as $package) {
            $packageName = AssetUtil::getName($package);
            // skip if package.json exist
            if ($event->hasAsset($packageName)) {
                continue;
            }
            // check NpmAsset or BowerAsset is exist
            $packageDependencies = [];
            foreach ($package->getRequires() as $require) {
                $target = $require->getTarget();
                if (strpos($target, 'npm-asset') !== false || strpos($target, 'bower-asset') !== false) {
                    $dependence = explode('/', $target)[1];
                    $constraint = $this->transConstraintComposer2Npm($require->getPrettyConstraint());
                    $packageDependencies[$dependence] = $constraint;
                }
            }
            if ($packageDependencies) {
                // generate package.json
                $packagePath = rtrim($assetDir, '/') . '/' . $package->getName();
                $newFilename = $packagePath . '/' . basename($filename);
                mkdir($packagePath, 0777, true);
                file_put_contents($newFilename, json_encode(['dependencies' => $packageDependencies]));

                $jsonFile = new JsonFile($newFilename);
                $packageValue = AssetUtil::formatPackage($package, $packageName, (array)$jsonFile->read());
                $jsonFile->write($packageValue);

                // addAsset
                $event->addAsset($packageName, $fs->findShortestPath(getcwd(), $newFilename));
            }
        }
    }

    /**
     * cover composer's require to npm's dependence
     * @link https://getcomposer.org/doc/04-schema.md#package-links
     * @link https://semver.npmjs.com/
     * @param $composerVersion
     * @return string
     */
    protected function transConstraintComposer2Npm($composerVersion)
    {
        $version = $composerVersion;
        // | -> ||
        $version = str_replace('|', '||', $version);
        $version = str_replace('||||', '||', $version);
        // remove @xxx
        $version = preg_replace('/(@[a-z0-9]*)/i', '', $version);

        return $version;
    }
}