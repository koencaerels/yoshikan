<?php

namespace App\YoshiKan\Application\Command\Member\CreateMemberFromSubscription;

use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;

class CreateMemberFromSubscriptionHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected MemberRepository       $memberRepository,
        protected GradeRepository        $gradeRepository,
    ) {
    }
    public function go(CreateMemberFromSubscription $command): bool
    {
        $subscription = $this->subscriptionRepository->getById($command->getId());
        $member = $this->memberRepository->findByNameAndDateOfBirth(
            $subscription->getFirstname(),
            $subscription->getLastname(),
            $subscription->getDateOfBirth()
        );
        if (is_null($member)) {
            $firstGrade = $this->gradeRepository->getFirst();
            $member = Member::make(
                $this->memberRepository->nextIdentity(),
                $subscription->getFirstname(),
                $subscription->getLastname(),
                $subscription->getDateOfBirth(),
                $subscription->getGender(),
                $firstGrade,
                $subscription->getLocation()
            );
            $this->memberRepository->save($member);
            $subscription->setMember($member);
            $this->subscriptionRepository->save($subscription);
            return true;
        } else {
            $subscription->setMember($member);
            $this->subscriptionRepository->save($subscription);
            return false;
        }
    }
}
