<?php

namespace Octopy\DataTable;

use Illuminate\Support\Facades\View;
use Octopy\DataTable\Contracts\DataTable as DataTableContract;
use Yajra\DataTables\DataTables;

abstract class DataTable implements DataTableContract
{
    /**
     * @var string
     */
    protected $model;

    /**
     * @var Yajra\DataTables\DataTables
     */
    protected $datatable;

    /**
     *
     */
    public function __construct()
    {
        View::addNamespace('datatable', __DIR__ . '/resources/views')->share('datatable', new DataTableHTMLBuilder($this));
    }

    /**
     * @return Collection
     */
    abstract public function query();

    /**
     * @param  DataTableHTMLBuilder $table
     * @return void
     */
    abstract public function html(DataTableHTMLBuilder $table): void;

    /**
     * @param  DataTableColumnBuilder $column
     * @return void
     */
    abstract public function json(DataTableColumnBuilder $column): void;

    /**
     * @param  string $template
     * @param  array  $data
     * @return Illuminate\View\View
     * @return Illuminate\Http\JsonResponse
     */
    public function render(string $template, array $data = [])
    {
        if (! app('request')->ajax()) {
            return view($template, $data);
        }

        return $this->make();
    }

    /**
     * @return Illuminate\Http\JsonResponse
     */
    protected function make()
    {
        $this->datatable = DataTables::of($this->query());

        if (method_exists($this, 'json')) {
            $this->json(new DataTableColumnBuilder($this->datatable));
        }

        return $this->datatable->make(true);
    }
}
