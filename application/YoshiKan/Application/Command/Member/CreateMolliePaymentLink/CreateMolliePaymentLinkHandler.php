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

namespace App\YoshiKan\Application\Command\Member\CreateMolliePaymentLink;

use App\YoshiKan\Domain\Model\Member\SubscriptionItemType;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Infrastructure\Mollie\MollieConfig;

class CreateMolliePaymentLinkHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected MollieConfig $mollieConfig,
    ) {
    }

    public function create(CreateMolliePaymentLink $command, bool $force = false): bool
    {
        $subscription = $this->subscriptionRepository->getById($command->getSubscriptionId());

        // -- link already created

        if (!$force && !(0 === mb_strlen($subscription->getPaymentId()))) {
            return false;
        }

        $paymentId = hash('SHA256', $subscription->getUuidAsString().'*'.$_SERVER['APP_SECRET']);
        $redirectUrl = $this->mollieConfig->getRedirectBaseUrl().'lidgeld/betaling/'.$paymentId;
        $webhookUrl = $this->mollieConfig->getRedirectBaseUrl().'lidgeld/betaling/'.$paymentId.'/webhook';

        // -- compile description for payment link -----------------------------
        $description = 'YKS-'.$subscription->getId().': ';
        $hasLicense = false;
        $hasMembership = false;

        foreach ($subscription->getItems() as $item) {
            if (SubscriptionItemType::LICENSE === $item->getType()) {
                $hasLicense = true;
            }
            if (SubscriptionItemType::MEMBERSHIP === $item->getType()) {
                $hasMembership = true;
            }
        }

        // -- create payment link -----------------------------------------------

        if ($hasLicense && $hasMembership) {
            $description .= 'Lidgeld (tot '.$subscription->getMemberSubscriptionEnd()->format('m/Y')
                .') en vergunning (tot '.$subscription->getLicenseEnd()->format('m/Y').') ';
        } elseif ($hasLicense) {
            $description .= 'Vergunning (tot '.$subscription->getMemberSubscriptionEnd()->format('m/Y').') ';
        } elseif ($hasMembership) {
            $description .= 'Lidgeld (tot '.$subscription->getLicenseEnd()->format('m/Y').') ';
        } else {
            $description .= 'Lidgeld ';
        }
        $description .= 'voor '.mb_strtoupper($subscription->getLastname()).' '.$subscription->getFirstname();

        $formattedAmount = number_format($subscription->getTotal(), 2, '.', '');

        if (0 !== strlen($this->mollieConfig->getApiKey())) {
            $mollie = new \Mollie\Api\MollieApiClient();
            $mollie->setApiKey($this->mollieConfig->getApiKey());
            $paymentLink = $mollie->paymentLinks->create([
                'amount' => [
                    'currency' => 'EUR',
                    'value' => $formattedAmount,
                ],
                'description' => $description,
                'redirectUrl' => $redirectUrl,
                'webhookUrl' => $webhookUrl,
            ]);
            $subscription->setMolliePaymentInfo(
                paymentId: $paymentId,
                paymentLink: $paymentLink->getCheckoutUrl(),
                paymentLinkId: $paymentLink->id,
            );
        }

        $this->subscriptionRepository->save($subscription);

        return true;
    }
}
