<?php
/**
 * This file is part of the mimmi20/laminas-form-element-paragraph package.
 *
 * Copyright (c) 2021-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\Form\Paragraph\Element;

use Laminas\Form\Element;
use Laminas\Form\Exception\InvalidArgumentException;
use Laminas\InputFilter\InputProviderInterface;

use function is_string;

final class Paragraph extends Element implements InputProviderInterface, ParagraphInterface
{
    private string $text = '';

    /**
     * Accepted options for MultiCheckbox:
     * - use_hidden_element: do we render hidden element?
     * - unchecked_value: value for checkbox when unchecked
     * - checked_value: value for checkbox when checked
     *
     * @param iterable<int, string> $options
     *
     * @throws InvalidArgumentException
     */
    public function setOptions(iterable $options): self
    {
        parent::setOptions($options);

        if (isset($this->options['text'])) {
            $text = $this->options['text'];

            if (!is_string($text)) {
                throw new InvalidArgumentException('The parameter must be a string');
            }

            $this->setText($text);
        }

        return $this;
    }

    /** @throws void */
    public function getText(): string
    {
        return $this->text;
    }

    /** @throws void */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Provide default input rules for this element
     *
     * @return array<string, false|string|null>
     * @phpstan-return array{name: string|null, required: false}
     *
     * @throws void
     */
    public function getInputSpecification(): array
    {
        return [
            'name' => $this->getName(),
            'required' => false,
        ];
    }

    /**
     * Set the element value, As this Element has no value to send with the form, no value is set
     *
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function setValue(mixed $value): self
    {
        return $this;
    }
}
