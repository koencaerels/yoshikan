<?php

declare(strict_types=1);

namespace App\YoshiKan\Infrastructure\Web\Twig;

use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EnvironmentExtension extends AbstractExtension
{
    public function __construct(protected KernelInterface $kernel)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'get_environment',
                [$this, 'getEnvironment'],
            ),
        ];
    }

    public function getEnvironment(): string
    {
        return $this->kernel->getEnvironment();
    }
}
