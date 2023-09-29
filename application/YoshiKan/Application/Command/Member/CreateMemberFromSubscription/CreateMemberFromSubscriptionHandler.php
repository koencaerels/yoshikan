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

namespace App\YoshiKan\Application\Command\Member\CreateMemberFromSubscription;

use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;

class CreateMemberFromSubscriptionHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected MemberRepository $memberRepository,
        protected GradeRepository $gradeRepository,
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

            // -- default values for new member fields
            $nationalRegisterNumber = '00.00.00-000.00';
            $addressStreet = '-';
            $addressNumber = '-';
            $addressBox = '';
            $addressZip = '-';
            $addressCity = '-';

            // -- take the values of the subscription if they are not null
            if (!is_null($subscription->getNationalRegisterNumber())) {
                $nationalRegisterNumber = $subscription->getNationalRegisterNumber();
            }
            if (!is_null($subscription->getAddressStreet())) {
                $addressStreet = $subscription->getAddressStreet();
            }
            if (!is_null($subscription->getAddressNumber())) {
                $addressNumber = $subscription->getAddressNumber();
            }
            if (!is_null($subscription->getAddressBox())) {
                $addressBox = $subscription->getAddressBox();
            }
            if (!is_null($subscription->getAddressZip())) {
                $addressZip = $subscription->getAddressZip();
            }
            if (!is_null($subscription->getAddressCity())) {
                $addressCity = $subscription->getAddressCity();
            }

            $member = Member::make(
                $this->memberRepository->nextIdentity(),
                $subscription->getFirstname(),
                $subscription->getLastname(),
                $subscription->getDateOfBirth(),
                $subscription->getGender(),
                $firstGrade,
                $subscription->getLocation(),
                $subscription->getFederation(),
                $command->getMemberEmail(),
                $nationalRegisterNumber,
                $addressStreet,
                $addressNumber,
                $addressBox,
                $addressZip,
                $addressCity,
                $subscription->getNumberOfTraining()
            );
            // -- set contact info
            $member->setContactInformation(
                $subscription->getContactFirstname(),
                $subscription->getContactLastname(),
                $subscription->getContactEmail(),
                $subscription->getContactPhone()
            );
            // -- set subscription dates
            $member->setSubscriptionDates(
                $subscription->getMemberSubscriptionStart(),
                $subscription->getMemberSubscriptionEnd(),
                $subscription->isMemberSubscriptionIsHalfYear()
            );
            // -- set license dates
            $member->setLicenseDates(
                $subscription->getLicenseStart(),
                $subscription->getLicenseEnd()
            );
            // -- save and connect the member
            $this->memberRepository->save($member);
            $subscription->setMember($member);
            $this->subscriptionRepository->save($subscription);

            return true;
        } else {
            // -- set contact info
            $member->setContactInformation(
                $subscription->getContactFirstname(),
                $subscription->getContactLastname(),
                $subscription->getContactEmail(),
                $subscription->getContactPhone()
            );
            // -- set subscription dates
            $member->setSubscriptionDates(
                $subscription->getMemberSubscriptionStart(),
                $subscription->getMemberSubscriptionEnd(),
                $subscription->isMemberSubscriptionIsHalfYear()
            );
            // -- set license dates
            $member->setLicenseDates(
                $subscription->getLicenseStart(),
                $subscription->getLicenseEnd()
            );
            // -- save and connect the member
            $this->memberRepository->save($member);

            $subscription->setMember($member);
            $this->subscriptionRepository->save($subscription);

            return false;
        }
    }
}
