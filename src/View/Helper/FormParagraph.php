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
use function array_merge;
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
    private Translate | null $translate;
    private EscapeHtml $escapeHtml;

    private string $indent = '';

    public function __construct(
        EscapeHtml $escaper,
        Translate | null $translator = null,
    ) {
        $this->escapeHtml = $escaper;
        $this->translate  = $translator;
    }

    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @return FormParagraph|string
     *
     * @throws Exception\InvalidArgumentException
     */
    public function __invoke(ElementInterface | null $element = null)
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

        $text = $element->getText();

        $classes    = [];
        $attributes = $element->getAttributes();

        if (array_key_exists('class', $attributes)) {
            $classes = array_merge($classes, explode(' ', $attributes['class']));
            unset($attributes['class']);
        }

        $attributes['class'] = trim(implode(' ', array_unique($classes)));

        if ('' !== $text) {
            // Translate the label
            if (null !== $this->translate) {
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
     * @param int|string $indent
     */
    public function setIndent($indent): self
    {
        $this->indent = $this->getWhitespace($indent);

        return $this;
    }

    /**
     * Returns indentation
     */
    public function getIndent(): string
    {
        return $this->indent;
    }

    // Util methods:

    /**
     * Retrieve whitespace representation of $indent
     *
     * @param int|string $indent
     */
    protected function getWhitespace($indent): string
    {
        if (is_int($indent)) {
            $indent = str_repeat(' ', $indent);
        }

        return (string) $indent;
    }
}
