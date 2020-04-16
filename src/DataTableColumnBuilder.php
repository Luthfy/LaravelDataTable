<?php

namespace Octopy\DataTable;

use Yajra\DataTables\CollectionDataTable;

final class DataTableColumnBuilder
{
    /**
     * @var Yajra\DataTables\CollectionDataTable
     */
    private $collection;

    /**
     * @param CollectionDataTable $collection
     */
    public function __construct(CollectionDataTable $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @param  string           $column
     * @param  string|callable  $value
     * @return void
     */
    public function add(string $column, $value): void
    {
        $this->collection->addColumn($column, $value);
    }

    /**
     * @param  string           $column
     * @param  string|callable  $value
     * @return void
     */
    public function edit(string $column, $value): void
    {
        $this->collection->editColumn($column, $value);
    }

    /**
     * @param  array $columns
     * @return void
     */
    public function raw(array $columns): void
    {
        $this->collection->rawColumns($columns);
    }

    /**
     * @param  array $columns
     * @return void
     */
    public function escape(array $columns = []): void
    {
        $this->collection->escapeColumns($columns);
    }
}
