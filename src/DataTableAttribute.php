<?php

namespace Octopy\DataTable;

final class DataTableAttribute
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $attr = [];

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param  string $property
     * @return string
     */
    public function __get(string $property)
    {
        return $this->$property ?? null;
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
     * @return DataTableAttribute
     */
    public function build(): DataTableAttribute
    {
        $attr = [];
        foreach ($this->attr as $name => $value) {
            $attr[] = sprintf(' %s="%s"', $name, $value);
        }

        $this->attr = implode('', $attr);

        return $this;
    }
}
