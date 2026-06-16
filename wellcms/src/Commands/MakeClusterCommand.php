<?php

namespace WellCMS\Commands;

use WellCMS\Facades\WellCMS;
use WellCMS\Panel;
use WellCMS\Support\Commands\Concerns\CanIndentStrings;
use WellCMS\Support\Commands\Concerns\CanManipulateFiles;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Attribute\AsCommand;

use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

#[AsCommand(name: 'make:wellcms-cluster')]
class MakeClusterCommand extends Command
{
    use CanIndentStrings;
    use CanManipulateFiles;

    protected $description = 'Create a new WellCMS cluster class';

    protected $signature = 'make:wellcms-cluster {name?} {--panel=} {--F|force}';

    public function handle(): int
    {
        $cluster = (string) str(
            $this->argument('name') ??
            text(
                label: 'What is the cluster name?',
                placeholder: 'Settings',
                required: true,
            ),
        )
            ->trim('/')
            ->trim('\\')
            ->trim(' ')
            ->replace('/', '\\');
        $clusterClass = (string) str($cluster)->afterLast('\\');
        $clusterNamespace = str($cluster)->contains('\\') ?
            (string) str($cluster)->beforeLast('\\') :
            '';

        $panel = $this->option('panel');

        if ($panel) {
            $panel = WellCMS::getPanel($panel, isStrict: false);
        }

        if (! $panel) {
            $panels = WellCMS::getPanels();

            /** @var Panel $panel */
            $panel = (count($panels) > 1) ? $panels[select(
                label: 'Which panel would you like to create this in?',
                options: array_map(
                    fn (Panel $panel): string => $panel->getId(),
                    $panels,
                ),
                default: WellCMS::getDefaultPanel()->getId()
            )] : Arr::first($panels);
        }

        $clusterDirectories = $panel->getClusterDirectories();
        $clusterNamespaces = $panel->getClusterNamespaces();

        foreach ($clusterDirectories as $clusterIndex => $clusterDirectory) {
            if (str($clusterDirectory)->startsWith(base_path('vendor'))) {
                unset($clusterDirectories[$clusterIndex]);
                unset($clusterNamespaces[$clusterIndex]);
            }
        }

        $namespace = (count($clusterNamespaces) > 1) ?
            select(
                label: 'Which namespace would you like to create this in?',
                options: $clusterNamespaces
            ) :
            (Arr::first($clusterNamespaces) ?? 'App\\WellCMS\\Clusters');
        $path = (count($clusterDirectories) > 1) ?
            $clusterDirectories[array_search($namespace, $clusterNamespaces)] :
            (Arr::first($clusterDirectories) ?? app_path('WellCMS/Clusters/'));

        $path = (string) str($cluster)
            ->prepend('/')
            ->prepend($path)
            ->replace('\\', '/')
            ->replace('//', '/')
            ->append('.php');

        $files = [$path];

        if (! $this->option('force') && $this->checkForCollision($files)) {
            return static::INVALID;
        }

        $this->copyStubToApp('Cluster', $path, [
            'class' => $clusterClass,
            'namespace' => $namespace . ($clusterNamespace !== '' ? "\\{$clusterNamespace}" : ''),
        ]);

        $this->components->info("WellCMS cluster [{$path}] created successfully.");

        if (empty($clusterNamespaces)) {
            $this->components->info('Make sure to register the cluster with `discoverClusters()` in the panel service provider.');
        }

        return static::SUCCESS;
    }
}
