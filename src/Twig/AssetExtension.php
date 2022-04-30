<?php

declare(strict_types=1);

namespace Blog\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AssetExtension extends AbstractExtension
{
    /**
     * @var array
     */
    private array $serverParams;

    private TwigFunctionFactory $twigFunctionFactory;

    /**
     * @param array $serverParams
     * @param TwigFunctionFactory $twigFunctionFactory
     */
    public function __construct(array $serverParams, TwigFunctionFactory $twigFunctionFactory)
    {
        $this->serverParams = $serverParams;
        $this->twigFunctionFactory = $twigFunctionFactory;
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            $this->twigFunctionFactory->create('asset_url', [$this, 'getAssetUrl']),
            $this->twigFunctionFactory->create('url', [$this, 'getUrl']),
            $this->twigFunctionFactory->create('base_url', [$this, 'getBaseUrl']),
        ];
    }

    /**
     * @param string $path
     * @return string
     */
    public function getAssetUrl(string $path): string
    {
        return $this->getBaseUrl() . $path;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->serverParams['REQUEST_SCHEME'] . '://' . $this->serverParams['HTTP_HOST'] . '/';
    }

    /**
     * @param string $path
     * @return string
     */
    public function getUrl(string $path): string
    {
        return $this->getBaseUrl() . $path;
    }
}