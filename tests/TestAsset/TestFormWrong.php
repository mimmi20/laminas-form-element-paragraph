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

namespace Mimmi20Test\Form\Element\Paragraph\TestAsset;

use Laminas\Form\Form;
use Mimmi20\Form\Element\Paragraph\Paragraph;

final class TestFormWrong extends Form
{
    public function __construct()
    {
        parent::__construct('collection');
        $this->setInputFilter(new InputFilter());

        $this->add(
            [
                'type' => Paragraph::class,
                'name' => 'paragraph',
                'options' => ['text' => 123],
            ]
        );
    }
}
