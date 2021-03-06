<?php
/**
 * This file is part of the mimmi20/laminas-form-element-paragraph package.
 *
 * Copyright (c) 2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\Form\Element\Paragraph;

use Laminas\Form\ElementFactory;

final class ConfigProvider
{
    /**
     * Return general-purpose laminas-navigation configuration.
     *
     * @return array<string, array<string, array<string, string>>>
     * @phpstan-return array{form_elements: array{aliases: array<string, class-string>, factories: array<class-string, class-string>}}
     */
    public function __invoke(): array
    {
        return [
            'form_elements' => $this->getFormElementConfig(),
        ];
    }

    /**
     * Return application-level dependency configuration.
     *
     * @return array<string, array<string, string>>
     * @phpstan-return array{aliases: array<string, class-string>, factories: array<class-string, class-string>}
     */
    public function getFormElementConfig(): array
    {
        return [
            'aliases' => [
                'paragraph' => Paragraph::class,
                ParagraphInterface::class => Paragraph::class,
            ],
            'factories' => [
                Paragraph::class => ElementFactory::class,
            ],
        ];
    }
}
