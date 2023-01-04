<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;

class Url extends FieldBuilder
{
    protected string $type = 'url';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'default_value' => '',
            'placeholder'   => '',
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
}
