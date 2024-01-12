<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\YoshiKan\Infrastructure\Mollie;

class MollieConfig
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected string $apiKey,
        protected string $partnerId,
        protected string $profileId,
        protected string $redirectBaseUrl,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        string $apiKey,
        string $partnerId,
        string $profileId,
        string $redirectBaseUrl,
    ): self {
        return new self(
            $apiKey,
            $partnerId,
            $profileId,
            $redirectBaseUrl,
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getPartnerId(): string
    {
        return $this->partnerId;
    }

    public function getProfileId(): string
    {
        return $this->profileId;
    }

    public function getRedirectBaseUrl(): string
    {
        return $this->redirectBaseUrl;
    }
}
