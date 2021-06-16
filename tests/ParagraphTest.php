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

namespace Mimmi20Test\Form\Element\Paragraph;

use Laminas\Form\Exception\DomainException;
use Laminas\Form\Exception\InvalidArgumentException;
use Mimmi20\Form\Element\Paragraph\Paragraph;
use Mimmi20Test\Form\Element\Paragraph\TestAsset\TestFormStringUrl;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;

use function assert;
use function get_class;
use function sprintf;

final class ParagraphTest extends TestCase
{
    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testSetStringHref(): void
    {
        $str       = 'http://www.test.com';
        $paragraph = new Paragraph();

        $paragraph->setText($str);

        self::assertSame($str, $paragraph->getText());
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testCanRetrieveDefaultSeparator(): void
    {
        $text      = 'http://www.test.com';
        $form      = new TestFormStringUrl();
        $paragraph = $form->get('paragraph');

        assert(
            $paragraph instanceof Paragraph,
            sprintf(
                '$paragraph should be an Instance of %s, but was %s',
                Paragraph::class,
                get_class($paragraph)
            )
        );

        self::assertSame($text, $paragraph->getText());
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    public function testValidationIsEveryTimeTrue(): void
    {
        $form = new TestFormStringUrl();

        $form->setData([]);

        self::assertTrue($form->isValid());
        self::assertSame(
            [],
            $form->getMessages()
        );
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testSetAndGetValue(): void
    {
        $text      = ' || ';
        $paragraph = new Paragraph();

        self::assertSame($paragraph, $paragraph->setValue($text));
        self::assertNotSame($text, $paragraph->getValue());
    }
}
