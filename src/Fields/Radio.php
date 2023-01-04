<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;
use InvalidArgumentException;

use function array_replace_recursive;
use function implode;
use function in_array;
use function is_array;
use function sprintf;

class Radio extends FieldBuilder
{
    protected string $type = 'radio';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'choices'           => [],
            'allow_null'        => 0,
            'other_choice'      => 0,
            'save_other_choice' => 0,
            'default_value'     => '',
            'layout'            => 'vertical',
            'return_format'     => 'value',
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    /**
     * @param string|array<string, mixed> $key
     * @param mixed                       $value
     */
    public function addChoices($key, $value): self
    {
        if (is_array($key)) {
            $keys = $key;
            foreach ($keys as $key => $value) {
                $this->config['choices'][$key] = $value;
            }
        } else {
            $this->config['choices'][$key] = $value;
        }

        return $this;
    }

    public function allowNull(): self
    {
        return $this->set('allow_null', 1);
    }

    public function disallowNull(): self
    {
        return $this->set('allow_null', 0);
    }

    public function allowCustomChoices(): self
    {
        return $this->set('other_choice', 1);
    }

    public function disallowCustomChoices(): self
    {
        return $this->set('other_choice', 0);
    }

    public function saveCustomChoices(): self
    {
        return $this->set('save_other_choice', 1);
    }

    public function doNotSaveCustomChoices(): self
    {
        return $this->set('save_other_choice', 0);
    }

    public function default(string $value): self
    {
        return $this->set('default_value', $value);
    }

    public function verticalLayout(): self
    {
        return $this->layout('vertical');
    }

    public function layout(string $layout): self
    {
        $supported = ['vertical', 'horizontal'];
        if (! in_array($layout, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided layout type is unsupported. Supported layouts: %s.',
                implode(', ', $supported)
            ));
        }

        return $this->set('layout', $layout);
    }

    public function horizontalLayout(): self
    {
        return $this->layout('horizontal');
    }

    public function returnFormat(string $format): self
    {
        $supported = ['value', 'label', 'array'];
        if (! in_array($format, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided return format is unsupported. Supported formats: %s.',
                implode(', ', $supported)
            ));
        }

        return $this->set('return_format', $format);
    }
}
