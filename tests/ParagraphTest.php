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
use Mimmi20Test\Form\Element\Paragraph\TestAsset\TestFormString;
use Mimmi20Test\Form\Element\Paragraph\TestAsset\TestFormWrong;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;

use function assert;
use function get_class;
use function sprintf;

final class ParagraphTest extends TestCase
{
    private const STR  = 'http://www.test.com';
    private const NAME = 'test.name';

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testSetStringHref(): void
    {
        $paragraph = new Paragraph();

        $paragraph->setText(self::STR);

        self::assertSame(self::STR, $paragraph->getText());
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testCanRetrieveText(): void
    {
        $text      = 'http://www.test.com';
        $form      = new TestFormString();
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
     * @throws InvalidArgumentException
     */
    public function testCanRetrieveTextException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('The parameter must be a string');

        new TestFormWrong();
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    public function testValidationIsEveryTimeTrue(): void
    {
        $form = new TestFormString();

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

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testGetInputSpecification(): void
    {
        $expected  = [
            'name' => self::NAME,
            'required' => false,
        ];
        $paragraph = new Paragraph();

        self::assertSame($paragraph, $paragraph->setName(self::NAME));
        self::assertSame(self::NAME, $paragraph->getName());
        self::assertSame($expected, $paragraph->getInputSpecification());
    }
}
