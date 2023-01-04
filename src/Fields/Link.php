<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;
use InvalidArgumentException;

use function array_replace_recursive;
use function implode;
use function in_array;
use function sprintf;

class Link extends FieldBuilder
{
    protected string $type = 'link';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive(['return_format' => 'array'], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function returnFormat(string $format): self
    {
        $supported = ['array', 'url'];
        if (! in_array($format, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided return format is unsupported. Supported formats: %s.',
                implode(', ', $supported)
            ));
        }

        return $this->set('return_format', $format);
    }
}
