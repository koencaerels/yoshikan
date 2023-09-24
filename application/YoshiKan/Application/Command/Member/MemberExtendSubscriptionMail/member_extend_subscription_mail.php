<?php

namespace App\YoshiKan\Application\Command\Member\MemberExtendSubscriptionMail;

trait member_extend_subscription_mail
{
    public function sendMemberExtendSubscriptionMail(int $subscriptionId): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = new MemberExtendSubscriptionMail(
            $subscriptionId,
            'Yoshi-Kan',
            'no-reply@yoshi-kan.be'
        );

        $handler = new MemberExtendSubscriptionMailHandler(
            $this->federationRepository,
            $this->locationRepository,
            $this->settingsRepository,
            $this->memberRepository,
            $this->subscriptionRepository,
            $this->subscriptionItemRepository,
            $this->messageRepository,
            $this->twig,
            $this->mailer
        );

        $result = $handler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
