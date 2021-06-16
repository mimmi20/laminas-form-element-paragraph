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

namespace Mimmi20Test\Form\Element\Paragraph;

use Mimmi20\Form\Element\Paragraph\ConfigProvider;
use Mimmi20\Form\Element\Paragraph\Paragraph;
use Mimmi20\Form\Element\Paragraph\ParagraphInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

final class ConfigProviderTest extends TestCase
{
    private ConfigProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new ConfigProvider();
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testProviderDefinesExpectedFactoryServices(): void
    {
        $formElementConfig = $this->provider->getFormElementConfig();
        self::assertCount(2, $formElementConfig);
        self::assertArrayHasKey('factories', $formElementConfig);
        $factories = $formElementConfig['factories'];
        self::assertIsArray($factories);
        self::assertCount(1, $factories);
        self::assertArrayHasKey(Paragraph::class, $factories);

        self::assertArrayHasKey('aliases', $formElementConfig);
        $aliases = $formElementConfig['aliases'];
        self::assertIsArray($aliases);
        self::assertCount(2, $aliases);
        self::assertArrayHasKey('paragraph', $aliases);
        self::assertArrayHasKey(ParagraphInterface::class, $aliases);
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testInvocationReturnsArrayWithDependencies(): void
    {
        $config = ($this->provider)();

        self::assertIsArray($config);
        self::assertCount(1, $config);
        self::assertArrayHasKey('form_elements', $config);

        $formElementConfig = $config['form_elements'];
        self::assertCount(2, $formElementConfig);
        self::assertArrayHasKey('factories', $formElementConfig);
        $factories = $formElementConfig['factories'];
        self::assertIsArray($factories);
        self::assertCount(1, $factories);
        self::assertArrayHasKey(Paragraph::class, $factories);

        self::assertArrayHasKey('aliases', $formElementConfig);
        $aliases = $formElementConfig['aliases'];
        self::assertIsArray($aliases);
        self::assertCount(2, $aliases);
        self::assertArrayHasKey('paragraph', $aliases);
        self::assertArrayHasKey(ParagraphInterface::class, $aliases);
    }
}
