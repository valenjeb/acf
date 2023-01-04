<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;
use InvalidArgumentException;

use function array_replace_recursive;
use function implode;
use function in_array;
use function sprintf;

class ColorPicker extends FieldBuilder
{
    protected string $type = 'color_picker';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'default_value'  => '',
            'enable_opacity' => 0,
            'return_format'  => 'string',
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function enableOpacity(): self
    {
        return $this->set('enable_opacity', 1);
    }

    public function disableOpacity(): self
    {
        return $this->set('enable_opacity', 0);
    }

    public function returnFormat(string $value): self
    {
        $supported = ['string', 'array'];
        if (! in_array($value, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided return format is unsupported. Supported formats: %s.',
                implode(', ', $supported)
            ));
        }

        return $this->set('return_format', $value);
    }
}
