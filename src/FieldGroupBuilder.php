<?php

declare(strict_types=1);

namespace Devly\ACF;

abstract class FieldGroupBuilder extends ParentDelegator
{
    use Traits\FieldsAggregator;

    /** @var array<string, mixed> */
    protected array $importedFields;

    /** @return array<string, mixed> */
    public function __debugInfo(): array
    {
        return $this->populate();
    }

    /** @return array<string, mixed> */
    abstract public function populate(): array;

    /** @param array<string, mixed>|SharedFieldGroup|FieldGroup $fields */
    public function import($fields): FieldGroupBuilder
    {
        if ($fields instanceof SharedFieldGroup || $fields instanceof FieldGroup) {
            $fields = $fields->populate();
        }

        foreach ($fields as $field) {
            $this->importedFields[] = $field;
        }

        return $this;
    }
}
