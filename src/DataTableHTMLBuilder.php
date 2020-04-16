<?php

namespace Octopy\DataTable;

use Closure;
use Exception;
use Illuminate\Support\Collection;
use ReflectionClass;

final class DataTableHTMLBuilder
{
    /**
     * @var Illuminate\Support\Collection
     */
    private $data;

    /**
     * @var array
     */
    private array $attr = [];

    /**
     * @var string
     */
    private string $ajax;

    /**
     * @param DataTable $datatable
     */
    public function __construct($datatable)
    {
        $this->data = new Collection();
        $this->ajax = app('request')->url();
        $this->attr([
            'id' => strtolower(str_replace('DataTable', '', (
                new ReflectionClass($datatable)
            )->getShortName())),
        ]);

        try {
            $datatable->html($this);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @return Illuminate\View\View
     */
    public function layout()
    {
        $data = $this->data->map(
            static fn ($row) => $row->map(
                static fn ($attr) => $attr->build()
            )
        );

        $attr = '';
        foreach ($this->attr as $name => $value) {
            $attr .= sprintf(' %s="%s"', $name, $value);
        }

        return view('datatable::layout', [
            'attr' => $attr,
            'data' => $data,
        ]);
    }

    /**
     * @return Illuminate\View\View
     */
    public function script()
    {
        return view('datatable::script', [
            'attr' => $this->attr,
            'ajax' => $this->ajax,
            'data' => $this->data->map(
                static fn ($row) => '{ data : "' . $row->get('td')->name . '" }'
            ),
        ]);
    }

    /**
     * @param  string|array $name
     * @param  string|null  $value
     * @return void
     */
    public function attr($name, ?string $value = null): void
    {
        if (is_array($name)) {
            $this->attr = array_merge($this->attr, $name);
        } else {
            $this->attr[$name] = $value;
        }
    }

    /**
     * @param  string               $th
     * @param  string|callable|null $td
     * @return DataTableAttribute
     */
    public function set(string $th, $td = null): DataTableAttribute
    {
        $td = $td ?? strtolower($th);

        $th = new DataTableAttribute($th);
        $this->data->push(collect(
            compact('th')
        ));

        if ($td instanceof Closure) {
            call_user_func($td, $this);
        } else {
            call_user_func([$this, 'key'], $td);
        }

        return $th;
    }

    /**
     * @param  string $td
     * @return DataTableAttribute
     */
    public function key(string $td): DataTableAttribute
    {
        $td = new DataTableAttribute($td);
        $this->data->push($this->data->pop()->merge(
            compact('td')
        ));

        return $td;
    }
}
