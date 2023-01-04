<?php

declare(strict_types=1);

namespace Devly\ACF;

use Devly\ACF\Traits\FieldsAggregator;

use function str_replace;
use function ucwords;

class Layout extends ParentDelegator
{
    use FieldsAggregator;

    protected string $key;
    /** @var array<string, mixed> */
    protected array $config;
    /** @var array<string, mixed> */
    protected array $importedFields;

    /** @param array<string, mixed> $config */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $this->key    = $key;
        $this->config = $config;
        $this->setParentContext($parentContext);
    }

    public function label(string $label): self
    {
        $this->config['label'] = $label;

        return $this;
    }

    public function name(string $name): self
    {
        $this->config['name'] = $name;

        return $this;
    }

    public function displayBlock(): self
    {
        return $this->set('display', 'block');
    }

    /** @param mixed $value */
    public function set(string $key, $value): self
    {
        $this->config[$key] = $value;

        return $this;
    }

    public function displayRow(): self
    {
        return $this->set('display', 'row');
    }

    public function displayTable(): self
    {
        return $this->set('display', 'table');
    }

    public function min(string $min): self
    {
        return $this->set('min', $min);
    }

    public function max(string $max): self
    {
        return $this->set('max', $max);
    }

    /** @return array<string, mixed> */
    public function populate(): array
    {
        $output = [
            'key'        => $this->key,
            'name'       => $this->config['name'] ?? $this->key,
            'label'      => $this->config['label'] ?? ucwords(str_replace('_', ' ', $this->key)),
            'display'    => $this->config['label'] ?? 'block',
            'sub_fields' => [],
            'min'        => $this->config['min'] ?? '',
            'max'        => $this->config['max'] ?? '',
        ];

        if (! isset($this->fields)) {
            return $output;
        }

        $fields = [];
        foreach ($this->fields as $field) {
            $fields[] = $field->populate();
        }

        if (isset($this->importedFields)) {
            foreach ($this->importedFields as $field) {
                $fields[] = $field;
            }
        }

        $output['sub_fields'] = $fields;

        return $output;
    }

    public function endLayout(): ?object
    {
        return $this->getParentContext();
    }

    /** @param array<string, mixed>|SharedFieldGroup|FieldGroup $fields */
    public function import($fields): self
    {
        $fields = $fields instanceof SharedFieldGroup || $fields instanceof FieldGroup ? $fields->populate() : $fields;

        foreach ($fields as $field) {
            $this->importedFields[] = $field;
        }

        return $this;
    }
}
