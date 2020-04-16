<?php

namespace Octopy\DataTable;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

final class DataTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:datatable {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new datatable class';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    public function handle()
    {
        $name = $this->argument('name');

        $template = str_replace(
            ['{{modelNamePlural}}', '{{modelNameSingular}}'],
            [Str::plural($name), $name],
            $this->stub()
        );

        $path = app_path('DataTables');

        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }

        if (file_exists($path . "/{$name}DataTable.php")) {
            return $this->info("{$name}DataTable already exists.");
        }

        file_put_contents($path . "/{$name}DataTable.php", $template);
    }

    /**
     * @return string
     */
    protected function stub()
    {
        return file_get_contents(__DIR__ . '/resources/stubs/DataTable.stub');
    }
}
