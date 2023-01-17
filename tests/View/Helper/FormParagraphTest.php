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

namespace Mimmi20Test\Form\Paragraph\View\Helper;

use Laminas\Form\Element\Text;
use Laminas\Form\Exception\InvalidArgumentException;
use Laminas\I18n\View\Helper\Translate;
use Laminas\View\Helper\EscapeHtml;
use Mimmi20\Form\Paragraph\Element\ParagraphInterface as ParagraphElement;
use Mimmi20\Form\Paragraph\View\Helper\FormParagraph;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;

use function assert;
use function sprintf;

final class FormParagraphTest extends TestCase
{
    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testRenderWithWrongElement(): void
    {
        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::never())
            ->method('__invoke');

        $helper = new FormParagraph($escapeHtml, null);

        $element = $this->getMockBuilder(Text::class)
            ->disableOriginalConstructor()
            ->getMock();
        $element->expects(self::never())
            ->method('getName');
        $element->expects(self::never())
            ->method('getAttributes');
        $element->expects(self::never())
            ->method('getValue');
        $element->expects(self::never())
            ->method('getLabelAttributes');
        $element->expects(self::never())
            ->method('getOption');
        $element->expects(self::never())
            ->method('getLabelOption');
        $element->expects(self::never())
            ->method('hasLabelOption');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                '%s requires that the element is of type %s',
                'Mimmi20\Form\Paragraph\View\Helper\FormParagraph::render',
                ParagraphElement::class,
            ),
        );
        $this->expectExceptionCode(0);

        $helper->render($element);
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testRenderEmptyString(): void
    {
        $class      = 'test-class';
        $ariaLabel  = 'test';
        $attributes = ['class' => $class, 'aria-label' => $ariaLabel];
        $expected   = sprintf('<p aria-label="%s" class="%s"></p>', $ariaLabel, $class);

        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::never())
            ->method('__invoke');

        $helper = new FormParagraph($escapeHtml, null);

        $element = $this->getMockBuilder(ParagraphElement::class)
            ->disableOriginalConstructor()
            ->getMock();
        $element->expects(self::once())
            ->method('getAttributes')
            ->willReturn($attributes);
        $element->expects(self::never())
            ->method('getValue');
        $element->expects(self::never())
            ->method('getOption');
        $element->expects(self::once())
            ->method('getText')
            ->willReturn('');

        self::assertSame($expected, $helper->render($element));
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testRenderText(): void
    {
        $text        = 'test-text';
        $textEscaped = 'test-text-escaped';
        $class       = 'test-class';
        $ariaLabel   = 'test';
        $attributes  = ['class' => $class, 'aria-label' => $ariaLabel];
        $expected    = sprintf('<p aria-label="%s" class="%s">%s</p>', $ariaLabel, $class, $textEscaped);

        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::once())
            ->method('__invoke')
            ->with($text)
            ->willReturn($textEscaped);

        $helper = new FormParagraph($escapeHtml, null);

        $element = $this->getMockBuilder(ParagraphElement::class)
            ->disableOriginalConstructor()
            ->getMock();
        $element->expects(self::once())
            ->method('getAttributes')
            ->willReturn($attributes);
        $element->expects(self::never())
            ->method('getValue');
        $element->expects(self::never())
            ->method('getOption');
        $element->expects(self::once())
            ->method('getText')
            ->willReturn($text);

        self::assertSame($expected, $helper->render($element));
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testRenderTextWithIndent(): void
    {
        $text        = 'test-text';
        $textEscaped = 'test-text-escaped';
        $class       = 'test-class';
        $ariaLabel   = 'test';
        $attributes  = ['class' => $class, 'aria-label' => $ariaLabel];
        $indent      = '    ';

        $expected = $indent . sprintf('<p aria-label="%s" class="%s">%s</p>', $ariaLabel, $class, $textEscaped);

        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::once())
            ->method('__invoke')
            ->with($text)
            ->willReturn($textEscaped);

        $helper = new FormParagraph($escapeHtml, null);

        $element = $this->getMockBuilder(ParagraphElement::class)
            ->disableOriginalConstructor()
            ->getMock();
        $element->expects(self::once())
            ->method('getAttributes')
            ->willReturn($attributes);
        $element->expects(self::never())
            ->method('getValue');
        $element->expects(self::never())
            ->method('getOption');
        $element->expects(self::once())
            ->method('getText')
            ->willReturn($text);

        $helper->setIndent($indent);

        self::assertSame($expected, $helper->render($element));
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testRenderTextWithTranslator(): void
    {
        $textDomain           = 'test-domain';
        $text                 = 'test-text';
        $textTranlated        = 'test-text-translated';
        $textTranlatedEscaped = 'test-text-translated-escaped';
        $class                = 'test-class';
        $ariaLabel            = 'test';
        $attributes           = ['class' => $class, 'aria-label' => $ariaLabel];

        $expected = sprintf('<p aria-label="%s" class="%s">%s</p>', $ariaLabel, $class, $textTranlatedEscaped);

        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::once())
            ->method('__invoke')
            ->with($textTranlated)
            ->willReturn($textTranlatedEscaped);

        $translator = $this->getMockBuilder(Translate::class)
            ->disableOriginalConstructor()
            ->getMock();
        $translator->expects(self::once())
            ->method('__invoke')
            ->with($text, $textDomain)
            ->willReturn($textTranlated);

        $helper = new FormParagraph($escapeHtml, $translator);

        $element = $this->getMockBuilder(ParagraphElement::class)
            ->disableOriginalConstructor()
            ->getMock();
        $element->expects(self::once())
            ->method('getAttributes')
            ->willReturn($attributes);
        $element->expects(self::never())
            ->method('getValue');
        $element->expects(self::never())
            ->method('getOption');
        $element->expects(self::once())
            ->method('getText')
            ->willReturn($text);

        $helper->setTranslatorTextDomain($textDomain);

        self::assertSame($expected, $helper->render($element));
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testInvokeTextWithTranslator1(): void
    {
        $textDomain           = 'test-domain';
        $text                 = 'test-text';
        $textTranlated        = 'test-text-translated';
        $textTranlatedEscaped = 'test-text-translated-escaped';
        $class                = 'test-class';
        $ariaLabel            = 'test';
        $attributes           = ['class' => $class, 'aria-label' => $ariaLabel];

        $expected = sprintf('<p aria-label="%s" class="%s">%s</p>', $ariaLabel, $class, $textTranlatedEscaped);

        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::once())
            ->method('__invoke')
            ->with($textTranlated)
            ->willReturn($textTranlatedEscaped);

        $translator = $this->getMockBuilder(Translate::class)
            ->disableOriginalConstructor()
            ->getMock();
        $translator->expects(self::once())
            ->method('__invoke')
            ->with($text, $textDomain)
            ->willReturn($textTranlated);

        $helper = new FormParagraph($escapeHtml, $translator);

        $element = $this->getMockBuilder(ParagraphElement::class)
            ->disableOriginalConstructor()
            ->getMock();
        $element->expects(self::once())
            ->method('getAttributes')
            ->willReturn($attributes);
        $element->expects(self::never())
            ->method('getValue');
        $element->expects(self::never())
            ->method('getOption');
        $element->expects(self::once())
            ->method('getText')
            ->willReturn($text);

        $helper->setTranslatorTextDomain($textDomain);

        $helperObject = $helper();

        assert($helperObject instanceof FormParagraph);

        self::assertSame($expected, $helperObject->render($element));
    }

    /**
     * @throws Exception
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testInvokeTextWithTranslator2(): void
    {
        $textDomain           = 'test-domain';
        $text                 = 'test-text';
        $textTranlated        = 'test-text-translated';
        $textTranlatedEscaped = 'test-text-translated-escaped';
        $class                = 'test-class1 test-class2 test-class1';
        $expectedClass        = 'test-class1&#x20;test-class2';
        $ariaLabel            = 'test';
        $attributes           = ['class' => $class, 'aria-label' => $ariaLabel];

        $expected = sprintf('<p aria-label="%s" class="%s">%s</p>', $ariaLabel, $expectedClass, $textTranlatedEscaped);

        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::once())
            ->method('__invoke')
            ->with($textTranlated)
            ->willReturn($textTranlatedEscaped);

        $translator = $this->getMockBuilder(Translate::class)
            ->disableOriginalConstructor()
            ->getMock();
        $translator->expects(self::once())
            ->method('__invoke')
            ->with($text, $textDomain)
            ->willReturn($textTranlated);

        $helper = new FormParagraph($escapeHtml, $translator);

        $element = $this->getMockBuilder(ParagraphElement::class)
            ->disableOriginalConstructor()
            ->getMock();
        $element->expects(self::once())
            ->method('getAttributes')
            ->willReturn($attributes);
        $element->expects(self::never())
            ->method('getValue');
        $element->expects(self::never())
            ->method('getOption');
        $element->expects(self::once())
            ->method('getText')
            ->willReturn($text);

        $helper->setTranslatorTextDomain($textDomain);

        self::assertSame($expected, $helper($element));
    }

    /**
     * @throws Exception
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testSetGetIndent1(): void
    {
        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::never())
            ->method('__invoke');

        $helper = new FormParagraph($escapeHtml, null);

        self::assertSame($helper, $helper->setIndent(4));
        self::assertSame('    ', $helper->getIndent());
    }

    /**
     * @throws Exception
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testSetGetIndent2(): void
    {
        $escapeHtml = $this->getMockBuilder(EscapeHtml::class)
            ->disableOriginalConstructor()
            ->getMock();
        $escapeHtml->expects(self::never())
            ->method('__invoke');

        $helper = new FormParagraph($escapeHtml, null);

        self::assertSame($helper, $helper->setIndent('  '));
        self::assertSame('  ', $helper->getIndent());
    }
}
