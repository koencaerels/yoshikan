<?php

namespace App\YoshiKan\Application\Command\Member\SendPaymentOverviewMail;

trait send_payment_overview_mail
{
    public function sendPaymentOverviewMail(int $subscriptionId): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = new SendPaymentOverviewMail(
            $subscriptionId,
            'Yoshi-Kan',
            'no-reply@yoshi-kan.be'
        );

        $handler = new SendPaymentOverviewMailHandler(
            $this->subscriptionRepository,
            $this->twig,
            $this->mailer
        );

        $result = $handler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
