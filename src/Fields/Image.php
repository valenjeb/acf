<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;
use InvalidArgumentException;

use function array_replace_recursive;
use function implode;
use function in_array;
use function sprintf;

class Image extends FieldBuilder
{
    protected string $type = 'image';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'library'       => 'all',
            'min_width'     => '',
            'min_height'    => '',
            'min_size'      => '',
            'max_width'     => '',
            'max_height'    => '',
            'max_size'      => '',
            'mime_types'    => '',
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function minWidth(string $width): self
    {
        return $this->set('min_width', $width);
    }

    public function minHeight(string $height): self
    {
        return $this->set('min_height', $height);
    }

    public function maxWidth(string $width): self
    {
        return $this->set('max_width', $width);
    }

    public function maxHeight(string $height): self
    {
        return $this->set('max_height', $height);
    }

    public function maxFileSize(string $height): self
    {
        return $this->set('max_size', $height);
    }

    public function minFileSize(string $height): self
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

    public function previewSize(string $value): self
    {
        return $this->set('preview_size', $value);
    }

    public function allowedFileTypes(string $value): self
    {
        return $this->set('mime_types', $value);
    }

    public function useGeneralLibrary(): self
    {
        return $this->set('library', 'all');
    }

    public function usePostLibrary(): self
    {
        return $this->set('library', 'uploadedTo');
    }
}
