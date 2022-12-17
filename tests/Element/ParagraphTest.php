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

namespace Mimmi20Test\Form\Paragraph\Element;

use Laminas\Form\Exception\DomainException;
use Laminas\Form\Exception\InvalidArgumentException;
use Mimmi20\Form\Paragraph\Element\Paragraph;
use Mimmi20Test\Form\Paragraph\TestAsset\TestFormString;
use Mimmi20Test\Form\Paragraph\TestAsset\TestFormWrong;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;

use function assert;
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
                $paragraph::class,
            ),
        );

        self::assertSame($text, $paragraph->getText());
    }

    /** @throws InvalidArgumentException */
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
            $form->getMessages(),
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
        $name      = 'test.name';
        $expected  = [
            'name' => $name,
            'required' => false,
        ];
        $paragraph = new Paragraph();

        self::assertSame($paragraph, $paragraph->setName($name));
        self::assertSame($name, $paragraph->getName());
        self::assertSame($expected, $paragraph->getInputSpecification());
    }
}
