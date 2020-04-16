<?php

namespace Octopy\DataTable\Contracts;

use Octopy\DataTable\DataTableColumnBuilder;
use Octopy\DataTable\DataTableHTMLBuilder;

interface DataTable
{
    /**
     * @return Collection
     */
    public function query();

    /**
     * @param DataTableHTMLBuilder $table
     */
    public function html(DataTableHTMLBuilder $table);

    /**
     * @param DataTableColumnBuilder $column
     */
    public function json(DataTableColumnBuilder $column);
}
