<?php

declare(strict_types=1);

namespace Devly\ACF;

class SharedFieldGroup extends FieldGroupBuilder
{
    public static function create(): self
    {
        return new self();
    }

    /** @return array<array<string, mixed>> */
    public function populate(): array
    {
        $fields = [];

        foreach ($this->fields as $field) {
            $fields[] = $field->populate();
        }

        if (isset($this->importedFields)) {
            foreach ($this->importedFields as $field) {
                $fields[] = $field;
            }
        }

        return $fields;
    }
}
