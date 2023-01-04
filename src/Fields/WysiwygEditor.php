<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;
use InvalidArgumentException;

use function array_replace_recursive;
use function implode;
use function in_array;
use function sprintf;

class WysiwygEditor extends FieldBuilder
{
    protected string $type = 'wysiwyg';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'default_value' => '',
            'tabs'          => 'all',
            'toolbar'       => 'full',
            'media_upload'  => 1,
            'delay'         => 0,
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function default(string $value): self
    {
        return $this->set('default_value', $value);
    }

    public function tabs(string $value): self
    {
        $supported = ['all', 'visual', 'text'];
        if (! in_array($value, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided tabs value is unsupported. Supported values: %s.',
                implode(', ', $supported)
            ));
        }

        return $this->set('tabs', $value);
    }

    public function visualTabs(): self
    {
        return $this->tabs('visual');
    }

    public function textTabs(): self
    {
        return $this->tabs('text');
    }

    public function allTabs(): self
    {
        return $this->tabs('all');
    }

    public function toolbar(string $value): self
    {
        $supported = ['full', 'basic'];
        if (! in_array($value, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided toolbar value is unsupported. Supported values: %s.',
                implode(', ', $supported)
            ));
        }

        return $this->set('toolbar', $value);
    }

    public function basicToolbar(): self
    {
        return $this->toolbar('basic');
    }

    public function fullToolbar(): self
    {
        return $this->toolbar('full');
    }

    public function hideMediaUploadButtons(): self
    {
        return $this->set('media_upload', 0);
    }

    public function showMediaUploadButtons(): self
    {
        return $this->set('media_upload', 1);
    }

    public function delay(bool $delay): self
    {
        return $this->set('delay', $delay ? 1 : 0);
    }

    public function delayInit(): self
    {
        return $this->delay(true);
    }

    public function doNotDelayInit(): self
    {
        return $this->delay(false);
    }
}
