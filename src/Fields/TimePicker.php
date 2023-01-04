<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;

class TimePicker extends FieldBuilder
{
    protected string $type = 'time_picker';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'display_format' => 'g:i a',
            'return_format' => 'g:i a',
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
}
