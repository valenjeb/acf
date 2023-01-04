<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;

class TrueFalse extends FieldBuilder
{
    protected string $type = 'true_false';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'message'       => '',
            'default_value' => 0,
            'ui'            => 0,
            'ui_on_text'    => '',
            'ui_off_text'   => '',
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function message(string $message): self
    {
        return $this->set('message', $message);
    }

    public function defaultValue(int $default): self
    {
        return $this->set('default_value', $default);
    }

    public function defaultTrue(): self
    {
        return $this->defaultValue(1);
    }

    public function stylisedUI(): self
    {
        return $this->set('ui', 1);
    }

    public function unstylisedUI(): self
    {
        return $this->set('ui', 0);
    }

    public function onText(string $text): self
    {
        return $this->set('ui_on_text', $text);
    }

    public function offText(string $text): self
    {
        return $this->set('ui_off_text', $text);
    }
}
