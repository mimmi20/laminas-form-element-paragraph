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

namespace Mimmi20Test\Form\Paragraph\TestAsset;

use Laminas\Form\Exception\InvalidArgumentException;
use Laminas\Form\Form;
use Mimmi20\Form\Paragraph\Element\Paragraph;

final class TestFormString extends Form
{
    /** @throws InvalidArgumentException */
    public function __construct()
    {
        parent::__construct('collection');

        $this->setInputFilter(new InputFilter());

        $this->add(
            [
                'name' => 'paragraph',
                'options' => ['text' => 'http://www.test.com'],
                'type' => Paragraph::class,
            ],
        );
    }
}
