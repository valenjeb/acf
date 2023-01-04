<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;

class Text extends FieldBuilder
{
    protected string $type = 'text';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'default_value' => '',
            'placeholder'   => '',
            'prepend'       => '',
            'append'        => '',
            'maxlength'     => '',
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function default(string $value): self
    {
        return $this->set('default_value', $value);
    }

    public function placeholder(string $value): self
    {
        return $this->set('placeholder', $value);
    }

    public function prepend(string $value): self
    {
        return $this->set('prepend', $value);
    }

    public function append(string $value): self
    {
        return $this->set('append', $value);
    }

    public function maxlength(int $value): self
    {
        return $this->set('maxlength', $value);
    }
}
