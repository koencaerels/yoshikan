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

namespace App\YoshiKan\Application\Command\TwoFactor\GenerateAndSendMemberAccessCode;

use App\YoshiKan\Domain\Model\TwoFactor\MemberAccessCode;
use App\YoshiKan\Domain\Model\TwoFactor\MemberAccessCodeRepository;
use Bolt\Entity\User;
use Bolt\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class GenerateAndSendMemberAccessCodeHandler
{
    public function __construct(
        protected UserRepository $userRepository,
        protected MemberAccessCodeRepository $memberAccessCodeRepository,
        protected Environment $twig,
        protected MailerInterface $mailer
    ) {
    }

    public function generateAndSend(GenerateAndSendMemberAccessCode $command): bool
    {
        /** @var ?User $user */
        $user = $this->userRepository->findOneBy(['id' => $command->getUserId()]);
        if (true === is_null($user)) {
            return false;
        }

        $subject = 'Yoshi-Kan - Toegangscode';
        $verificationCode = rand(100000, 999999);
        $hashedCode = hash('SHA256', (string) $verificationCode.'*'.$_SERVER['APP_SECRET']);
        $memberAccessCode = MemberAccessCode::make(
            user: $user,
            uuid: $this->memberAccessCodeRepository->nextIdentity(),
            code: $hashedCode,
        );

        $this->memberAccessCodeRepository->save($memberAccessCode);

        // -- make template ---------------------------------------------
        $magicLink = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/beheer/leden#/login/'.$verificationCode;
        $mailTemplate = $this->twig->render(
            'mail/member_access_code_mail.html.twig',
            [
                'subject' => $subject,
                'user' => $user,
                'code' => $verificationCode,
                'url' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'],
                'magicLink' => $magicLink,
            ]
        );

        // -- send email via resend  ---------------------------------------

        $resend = \Resend::client($_SERVER['RESEND_API_KEY']);
        $resend->emails->send([
            'from' => $command->getFromName().' <'.$command->getFromEmail().'>',
            'to' => [$user->getEmail()],
            'subject' => $subject,
            'html' => $mailTemplate,
        ]);

        return true;
    }
}
