<?php
/**
 * This file is part of the mimmi20/laminas-form-element-paragraph package.
 *
 * Copyright (c) 2021-2022, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\Form\Paragraph\View\Helper;

use Interop\Container\ContainerInterface;
use Laminas\I18n\View\Helper\Translate;
use Laminas\View\Helper\EscapeHtml;
use Laminas\View\HelperPluginManager;
use Psr\Container\ContainerExceptionInterface;

use function assert;
use function gettype;
use function is_object;
use function sprintf;

final class FormParagraphFactory
{
    /** @throws ContainerExceptionInterface */
    public function __invoke(ContainerInterface $container): FormParagraph
    {
        $plugin = $container->get(HelperPluginManager::class);
        assert(
            $plugin instanceof HelperPluginManager,
            sprintf(
                '$plugin should be an Instance of %s, but was %s',
                HelperPluginManager::class,
                is_object($plugin) ? $plugin::class : gettype($plugin),
            ),
        );

        $translator = null;

        if ($plugin->has(Translate::class)) {
            $translator = $plugin->get(Translate::class);

            assert($translator instanceof Translate);
        }

        $escapeHtml = $plugin->get(EscapeHtml::class);

        assert($escapeHtml instanceof EscapeHtml);

        return new FormParagraph($escapeHtml, $translator);
    }
}
