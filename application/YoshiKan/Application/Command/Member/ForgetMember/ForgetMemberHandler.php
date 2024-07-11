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

namespace App\YoshiKan\Application\Command\Member\ForgetMember;

use App\YoshiKan\Domain\Model\Member\GradeLogRepository;
use App\YoshiKan\Domain\Model\Member\MemberImageRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionItemRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Message\MessageRepository;

class ForgetMemberHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected SubscriptionItemRepository $subscriptionItemRepository,
        protected MemberRepository $memberRepository,
        protected MemberImageRepository $memberImageRepository,
        protected GradeLogRepository $gradeLogRepository,
        protected MessageRepository $messageRepository,
        protected string $uploadFolder,
    ) {
    }

    public function forget(ForgetMember $command): bool
    {
        $member = $this->memberRepository->getById($command->getMemberId());

        // -- remove the gradelogs ---------------------------------------------
        foreach ($member->getGradeLogs() as $gradeLog) {
            $this->gradeLogRepository->delete($gradeLog);
        }

        // -- remove the messages ----------------------------------------------
        foreach ($member->getMessages() as $message) {
            $this->messageRepository->delete($message);
        }

        // -- remove the member images -----------------------------------------
        foreach ($member->getMemberImages() as $memberImage) {
            $imagePath = $this->uploadFolder.$memberImage->getPath();
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $this->memberImageRepository->delete($memberImage);
        }

        // -- remove the subscription and subscription items ------------------
        /** @var Subscription $subscription */
        foreach ($member->getSubscriptions() as $subscription) {
            foreach ($subscription->getItems() as $subscriptionItem) {
                $this->subscriptionItemRepository->delete($subscriptionItem);
            }
            $this->subscriptionRepository->delete($subscription);
        }

        // -- remove the member ------------------------------------------------
        $this->memberRepository->delete($member);

        return true;
    }
}
