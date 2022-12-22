<?php

namespace App\YoshiKan\Application\Command\Member\WebConfirmationMail;

trait web_confirmation_mail
{

    public function WebConfirmationMail(int $subscriptionId): bool
    {
        $command = new WebConfirmationMail($subscriptionId,'Yoshi-Kan','no-reply@yoshi-kan.be');
        $handler = new WebConfirmationMailHandler(
            $this->subscriptionRepository,
            $this->twig,
            $this->mailer
        );
        return $handler->go($command);
    }

}
