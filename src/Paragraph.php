<?php
/**
 * This file is part of the mimmi20/laminas-form-element-links package.
 *
 * Copyright (c) 2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\Form\Element\Paragraph;

use Laminas\Form\Element;
use Laminas\Form\Exception\InvalidArgumentException;
use Laminas\InputFilter\InputProviderInterface;
use Traversable;

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
     * @param array<int, string>|Traversable $options
     *
     * @throws InvalidArgumentException
     */
    public function setOptions($options): self
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

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Provide default input rules for this element
     *
     * @return array<string, array<int, array<string, class-string>>|int|string|false>
     * @phpstan-return array('name' => string|null, 'required' => false)
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
     * @param mixed $value
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function setValue($value): self
    {
        return $this;
    }
}
