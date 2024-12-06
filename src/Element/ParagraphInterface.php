<?php

/**
 * This file is part of the mimmi20/laminas-form-element-paragraph package.
 *
 * Copyright (c) 2021-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\Form\Paragraph\Element;

use Laminas\Form\ElementInterface;
use Laminas\Form\Exception\InvalidArgumentException;
use Override;

interface ParagraphInterface extends ElementInterface
{
    /**
     * Accepted options for MultiCheckbox:
     * - use_hidden_element: do we render hidden element?
     * - unchecked_value: value for checkbox when unchecked
     * - checked_value: value for checkbox when checked
     *
     * @param iterable<int, string> $options
     *
     * @return self
     *
     * @throws InvalidArgumentException
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingNativeTypeHint
     */
    #[Override]
    public function setOptions(iterable $options);

    /** @throws void */
    public function getText(): string;

    /**
     * @return self
     *
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingNativeTypeHint
     */
    public function setText(string $text);
}
