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

namespace App\YoshiKan\Application\Command\Member\NewMemberSubscription;

use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionItemRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;

class NewMemberSubscriptionHandler
{
    // ———————————————————————————————————————————————————————————————
    // Constructor
    // ———————————————————————————————————————————————————————————————

    public function __construct(
        protected FederationRepository $federationRepository,
        protected LocationRepository $locationRepository,
        protected SettingsRepository $settingsRepository,
        protected MemberRepository $memberRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected SubscriptionItemRepository $subscriptionItemRepository,
        protected EntityManagerInterface $entityManager,
    ) {
    }

    // ———————————————————————————————————————————————————————————————
    // Handle
    // ———————————————————————————————————————————————————————————————

    public function go(NewMemberSubscription $command): \stdClass
    {
        return new \stdClass();
    }
}
