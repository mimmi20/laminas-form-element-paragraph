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

use Laminas\Form\ElementInterface;
use Laminas\Form\Exception;
use Laminas\Form\View\Helper\AbstractHelper;
use Laminas\I18n\View\Helper\Translate;
use Laminas\View\Helper\EscapeHtml;
use Mimmi20\Form\Paragraph\Element\ParagraphInterface as ParagraphElement;

use function array_key_exists;
use function array_unique;
use function assert;
use function explode;
use function implode;
use function is_int;
use function is_string;
use function sprintf;
use function str_repeat;
use function trim;

final class FormParagraph extends AbstractHelper
{
    private string $indent = '';

    /** @throws void */
    public function __construct(
        private readonly EscapeHtml $escapeHtml,
        private readonly Translate | null $translate = null,
    ) {
    }

    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @throws Exception\InvalidArgumentException
     */
    public function __invoke(ElementInterface | null $element = null): self | string
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * Render a form <select> element from the provided $element
     *
     * @throws Exception\InvalidArgumentException
     */
    public function render(ElementInterface $element): string
    {
        if (!$element instanceof ParagraphElement) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s requires that the element is of type %s',
                    __METHOD__,
                    ParagraphElement::class,
                ),
            );
        }

        $text       = $element->getText();
        $attributes = $element->getAttributes();

        if (array_key_exists('class', $attributes)) {
            $classes = [];

            if (is_string($attributes['class'])) {
                $classes = array_unique(explode(' ', $attributes['class']));
            }

            unset($attributes['class']);

            if ($classes !== []) {
                $attributes['class'] = trim(implode(' ', $classes));
            }
        }

        if ($text !== '') {
            // Translate the label
            if ($this->translate !== null) {
                $text = ($this->translate)($text, $this->getTranslatorTextDomain());
            }

            $text = ($this->escapeHtml)($text);

            assert(is_string($text));
        }

        $renderedElement = sprintf(
            '<p %s>%s</p>',
            $this->createAttributesString($attributes),
            $text,
        );

        $indent = $this->getIndent();

        return $indent . $renderedElement;
    }

    /**
     * Set the indentation string for using in {@link render()}, optionally a
     * number of spaces to indent with
     *
     * @throws void
     */
    public function setIndent(int | string $indent): self
    {
        $this->indent = $this->getWhitespace($indent);

        return $this;
    }

    /**
     * Returns indentation
     *
     * @throws void
     */
    public function getIndent(): string
    {
        return $this->indent;
    }

    // Util methods:

    /**
     * Retrieve whitespace representation of $indent
     *
     * @throws void
     */
    private function getWhitespace(int | string $indent): string
    {
        if (is_int($indent)) {
            $indent = str_repeat(' ', $indent);
        }

        return $indent;
    }
}
