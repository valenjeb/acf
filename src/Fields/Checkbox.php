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

class Checkbox extends FieldBuilder
{
    protected string $type = 'checkbox';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'choices' => [],
            'allow_custom' => 0,
            'default_value' => [],
            'layout' => 'vertical',
            'toggle' => 0,
            'return_format' => 'value',
            'save_custom' => 0,
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    /**
     * @param string|array<string, mixed> $key
     * @param mixed                       $value
     */
    public function addChoices($key, $value = null): self
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

    /**
     * @param string|string[] $value
     *
     * @return Checkbox
     */
    public function addDefaults($value): self
    {
        if (is_array($value)) {
            $values = $value;
            foreach ($values as $value) {
                $this->config['default_value'] = $value;
            }
        } else {
            $this->config['default_value'] = $value;
        }

        return $this;
    }

    public function allowCustom(): self
    {
        return $this->set('allow_custom', 1);
    }

    public function disallowCustom(): self
    {
        return $this->set('allow_custom', 0);
    }

    public function saveCustom(): self
    {
        return $this->set('save_custom', 1);
    }

    public function toggle(): self
    {
        return $this->set('toggle', 1);
    }

    public function addToggle(): self
    {
        return $this->toggle();
    }

    public function layout(string $layout): self
    {
        $supported = ['vertical', 'horizontal'];
        if (! in_array($layout, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided layout type is unsupported. Supported layouts: %s',
                implode(', ', $supported)
            ));
        }

        return $this->set('layout', $layout);
    }

    public function verticalLayout(): self
    {
        return $this->layout('vertical');
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
                'Provided return format is unsupported. Supported formats: %s',
                implode(', ', $supported)
            ));
        }

        return $this->set('return_format', $format);
    }
}
