<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;

class DateTimePicker extends FieldBuilder
{
    protected string $type = 'date_time_picker';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'display_format' => 'd/m/Y g:i a',
            'return_format'  => 'd/m/Y g:i a',
            'first_day'      => 0,
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function displayFormat(string $format): self
    {
        return $this->set('display_format', $format);
    }

    public function returnFormat(string $format): self
    {
        return $this->set('return_format', $format);
    }

    public function weekStartsOnSunday(): self
    {
        return $this->set('first_day', 0);
    }

    public function weekStartsOnMonday(): self
    {
        return $this->set('first_day', 1);
    }

    public function weekStartsOnTuesday(): self
    {
        return $this->set('first_day', 2);
    }

    public function weekStartsOnWednesday(): self
    {
        return $this->set('first_day', 3);
    }

    public function weekStartsOnThursday(): self
    {
        return $this->set('first_day', 4);
    }

    public function weekStartsOnFriday(): self
    {
        return $this->set('first_day', 5);
    }

    public function weekStartsOnSaturday(): self
    {
        return $this->set('first_day', 6);
    }
}
