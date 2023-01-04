<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;
use Devly\ACF\Traits\FieldsAggregator;

use function array_replace_recursive;

class Repeater extends FieldBuilder
{
    use FieldsAggregator;

    protected string $type = 'repeater';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'collapsed'    => '',
            'min'          => 0,
            'max'          => 0,
            'layout'       => 'table',
            'button_label' => '',
            'sub_fields'   => [],
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function showWhenCollapsed(string $key): self
    {
        return $this->set('collapsed', $key);
    }

    public function buttonLabel(string $label): self
    {
        return $this->set('button_label', $label);
    }

    public function minRows(int $min): self
    {
        return $this->set('min', $min);
    }

    public function maxRows(int $min): self
    {
        return $this->set('max', $min);
    }

    public function blockLayout(): self
    {
        return $this->set('layout', 'block');
    }

    public function tableLayout(): self
    {
        return $this->set('layout', 'table');
    }

    public function rowLayout(): self
    {
        return $this->set('layout', 'row');
    }

    public function endRepeater(): ?object
    {
        return $this->getParentContext();
    }

    /** @return array<string, mixed> */
    public function populate(): array
    {
        $populated = parent::populate();

        if (! isset($this->fields)) {
            return $populated;
        }

        $subfields = [];
        foreach ($this->fields as $field) {
            $subfields[] = $field->populate();
        }

        $populated['sub_fields'] = $subfields;

        return $populated;
    }
}
