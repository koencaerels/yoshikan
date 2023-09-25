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

namespace App\YoshiKan\Application\Command\Member\MemberExtendSubscriptionMail;

use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionItemRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionType;
use App\YoshiKan\Domain\Model\Message\Message;
use App\YoshiKan\Domain\Model\Message\MessageRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MemberExtendSubscriptionMailHandler
{
    public function __construct(
        protected FederationRepository $federationRepository,
        protected LocationRepository $locationRepository,
        protected SettingsRepository $settingsRepository,
        protected MemberRepository $memberRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected SubscriptionItemRepository $subscriptionItemRepository,
        protected MessageRepository $messageRepository,
        protected Environment $twig,
        protected MailerInterface $mailer
    ) {
    }

    public function go(MemberExtendSubscriptionMail $command): bool
    {
        $subscription = $this->subscriptionRepository->getById($command->getSubscriptionId());
        $items = $this->subscriptionItemRepository->getBySubscription($subscription);

        switch ($subscription->getType()) {
            case SubscriptionType::RENEWAL_LICENSE:
                $subject = 'JC Yoshi-Kan: Vernieuwing vergunning voor ' . $subscription->getFirstname() . ' ' . $subscription->getLastname();
                break;
            case SubscriptionType::RENEWAL_MEMBERSHIP:
                $subject = 'JC Yoshi-Kan: Vernieuwing lidmaatschap voor ' . $subscription->getFirstname() . ' ' . $subscription->getLastname();
                break;
            case SubscriptionType::RENEWAL_FULL:
                $subject = 'JC Yoshi-Kan: Vernieuwing lidmaatschap + vergunning voor ' . $subscription->getFirstname() . ' ' . $subscription->getLastname();
                break;
            default:
                $subject = 'JC Yoshi-Kan';
                break;
        }

        $mailTemplate = $this->twig->render(
            'mail/member_extendMemberSubscription_mail.html.twig',
            [
                'subject' => $subject,
                'subscription' => $subscription,
                'items' => $items,
                'url' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'],
            ]
        );

        // -- send email -----------------------------------------------------------------------------------------------

        $message = (new Email())
            ->subject($subject)
            ->from(new Address($command->getFromEmail(), $command->getFromName()))
            ->to(new Address($subscription->getContactEmail(), $subscription->getContactFirstname() . ' ' . $subscription->getContactLastname()))
            ->html($mailTemplate);

        $this->mailer->send($message);

        // -- record message and flag as send --------------------------------------------------------------------------

        $message = Message::make(
            $this->messageRepository->nextIdentity(),
            new \DateTimeImmutable(),
            $command->getFromName(),
            $command->getFromEmail(),
            $subscription->getContactFirstname() . ' ' . $subscription->getContactLastname(),
            $subscription->getContactEmail(),
            $subject,
            $mailTemplate,
        );
        $message->setMember($subscription->getMember());
        $message->setSubscription($subscription);
        $this->messageRepository->save($message);

        $subscription->flagPaymentOverviewMailSend();
        $this->subscriptionRepository->save($subscription);

        return true;
    }
}
