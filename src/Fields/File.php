<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;
use InvalidArgumentException;

use function array_replace_recursive;
use function implode;
use function in_array;
use function sprintf;

class File extends FieldBuilder
{
    protected string $type = 'file';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'return_format' => 'array',
            'library'       => 'all',
            'min_size'      => '',
            'max_size'      => '',
            'mime_types'    => '',
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function maxSize(string $height): self
    {
        return $this->set('max_size', $height);
    }

    public function minSize(string $height): self
    {
        return $this->set('min_size', $height);
    }

    public function returnFormat(string $value): self
    {
        $supported = ['id', 'array', 'url'];
        if (! in_array($value, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided return format value is unsupported. Supported values: %s.',
                implode(', ', $supported)
            ));
        }

        return $this->set('return_format', $value);
    }

    public function allowedFileTypes(string $value): self
    {
        return $this->set('mime_types', $value);
    }
}
