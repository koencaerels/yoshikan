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

namespace App\YoshiKan\Application\Command\Import\FixEmail;

use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;

class FixEmailHandler
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected MemberRepository $memberRepository,
        protected SubscriptionRepository $subscriptionRepository,
    ) {
    }

    public function fixSubscriptions(): bool
    {
        $allSubscriptions = $this->subscriptionRepository->getAll();

        /** @var Subscription $subscription */
        foreach ($allSubscriptions as $subscription) {
            $filteredEmail = str_replace(' ', '', $subscription->getContactEmail());
            $filteredEmail = str_replace(';', '.', $filteredEmail);
            $filteredEmail = str_replace('?', '.', $filteredEmail);
            $filteredEmail = str_replace('²', '@', $filteredEmail);
            $filteredEmail = strtolower($filteredEmail);

            $subscription->setContactEmail($filteredEmail);
            $this->subscriptionRepository->save($subscription);
            $this->entityManager->flush();

            echo '<br>'.$subscription->getContactFirstname().' '.$subscription->getContactLastname().' -> '.$subscription->getContactEmail();
            ob_flush();
            flush();
        }

        return true;
    }

    public function fixMembers(): bool
    {
        $allMembers = $this->memberRepository->getAll();

        foreach ($allMembers as $member) {
            $filteredEmail = str_replace(' ', '', $member->getContactEmail());
            $filteredEmail = str_replace(';', '.', $filteredEmail);
            $filteredEmail = str_replace('?', '.', $filteredEmail);
            $filteredEmail = str_replace('²', '@', $filteredEmail);
            $filteredEmail = strtolower($filteredEmail);

            if ('' === $filteredEmail) {
                $filteredEmail = 'judo.yoshikan@gmail.com';
            }

            $member->setContactInformation(
                contactFirstname: $member->getContactFirstname(),
                contactLastname: $member->getContactLastname(),
                contactEmail: $filteredEmail,
                contactPhone: $member->getContactPhone()
            );
            $this->memberRepository->save($member);
            $this->entityManager->flush();

            echo '<br>'.$member->getFirstname().' '.$member->getLastname().' -> '.$member->getContactEmail();
            ob_flush();
            flush();
        }

        return true;
    }
}
