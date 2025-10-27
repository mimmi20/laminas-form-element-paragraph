<?php

/**
 * This file is part of the mimmi20/laminas-form-element-paragraph package.
 *
 * Copyright (c) 2021-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\Form\Paragraph;

use Laminas\Form\ElementFactory;
use Mimmi20\Form\Paragraph\Element\Paragraph;
use Mimmi20\Form\Paragraph\Element\ParagraphInterface;
use Mimmi20\Form\Paragraph\View\Helper\FormParagraph;
use Mimmi20\Form\Paragraph\View\Helper\FormParagraphFactory;

final class ConfigProvider
{
    /**
     * Return general-purpose laminas-navigation configuration.
     *
     * @return array<string, array<string, array<string, string>>>
     * @phpstan-return array{form_elements: array{aliases: array<string, class-string>, factories: array<class-string, class-string>}, view_helpers: array{aliases: array<string, class-string>, factories: array<class-string, class-string>}}
     *
     * @throws void
     */
    public function __invoke(): array
    {
        return [
            'form_elements' => $this->getFormElementConfig(),
            'view_helpers' => $this->getViewHelperConfig(),
        ];
    }

    /**
     * Return application-level dependency configuration.
     *
     * @return array<string, array<string, string>>
     * @phpstan-return array{aliases: array<string, class-string>, factories: array<class-string, class-string>}
     *
     * @throws void
     *
     * @api
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

    /**
     * Return application-level dependency configuration.
     *
     * @return array<string, array<string, string>>
     * @phpstan-return array{aliases: array<string, class-string>, factories: array<class-string, class-string>}
     *
     * @throws void
     *
     * @api
     */
    public function getViewHelperConfig(): array
    {
        return [
            'aliases' => [
                'formparagraph' => FormParagraph::class,
                'formParagraph' => FormParagraph::class,
                'FormParagraph' => FormParagraph::class,
                'form_paragraph' => FormParagraph::class,
            ],
            'factories' => [
                FormParagraph::class => FormParagraphFactory::class,
            ],
        ];
    }
}
