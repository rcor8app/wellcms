<?php

namespace WellCMS\Support\Commands;

use WellCMS\Support\Commands\Concerns\CanManipulateFiles;
use WellCMS\Support\Facades\WellCMSAsset;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'wellcms:assets')]
class AssetsCommand extends Command
{
    use CanManipulateFiles;

    protected $description = 'Set up WellCMS assets';

    protected $signature = 'wellcms:assets';

    /** @var array<string> */
    protected array $publishedAssets = [];

    public function handle(): int
    {
        foreach (WellCMSAsset::getAlpineComponents() as $asset) {
            if ($asset->isRemote()) {
                continue;
            }

            $this->copyAsset($asset->getPath(), $asset->getPublicPath());
        }

        foreach (WellCMSAsset::getScripts() as $asset) {
            if ($asset->isRemote()) {
                continue;
            }

            $this->copyAsset($asset->getPath(), $asset->getPublicPath());
        }

        foreach (WellCMSAsset::getStyles() as $asset) {
            if ($asset->isRemote()) {
                continue;
            }

            $this->copyAsset($asset->getPath(), $asset->getPublicPath());
        }

        foreach (WellCMSAsset::getThemes() as $asset) {
            if ($asset->isRemote()) {
                continue;
            }

            $this->copyAsset($asset->getPath(), $asset->getPublicPath());
        }

        $this->components->bulletList($this->publishedAssets);

        $this->components->info('Successfully published assets!');

        return static::SUCCESS;
    }

    protected function copyAsset(string $from, string $to): void
    {
        $filesystem = app(Filesystem::class);

        [$from, $to] = str_replace('/', DIRECTORY_SEPARATOR, [$from, $to]);

        $filesystem->ensureDirectoryExists(
            (string) str($to)
                ->beforeLast(DIRECTORY_SEPARATOR),
        );

        $filesystem->copy($from, $to);

        $this->publishedAssets[] = $to;
    }
}
