<?php

namespace App\YoshiKan\Application\Command\Common;

use App\YoshiKan\Domain\Model\Member\Federation;
use App\YoshiKan\Domain\Model\Member\Settings;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionItem;
use App\YoshiKan\Domain\Model\Member\SubscriptionItemRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionItemType;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;

class SubscriptionItemsFactory
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected SubscriptionItemRepository $subscriptionItemRepository,
    ) {
    }

    public function saveItemsFromSubscription(
        Subscription $subscription,
        Federation $federation,
        Settings $settings
    ): bool {
        $sequence = 0;

        // -- membership lines -----------------------------------------------------------------------------------------

        if ($subscription->isMemberSubscriptionIsPartSubscription()) {
            ++$sequence;
            $itemName = 'Lidmaatschap van '
                . $this->_format($subscription->getMemberSubscriptionStart()) . ' tot '
                . $this->_format($subscription->getMemberSubscriptionEnd()) . ': ';

            if (1 === $subscription->getNumberOfTraining()) {
                $itemName .= '1 training per week.';
            } elseif (2 === $subscription->getNumberOfTraining()) {
                $itemName .= '2 trainingen per week.';
            }

            $fee = $subscription->getSubscriptionFee(false);

            $subscriptionItemMembership = SubscriptionItem::make(
                $this->subscriptionItemRepository->nextIdentity(),
                SubscriptionItemType::MEMBERSHIP,
                $itemName,
                $fee,
                $subscription
            );
            $subscriptionItemMembership->setSequence($sequence);
            $this->subscriptionItemRepository->save($subscriptionItemMembership);

            if (3 === $subscription->getNumberOfTraining()) {
                ++$sequence;
                $itemName = '3 tot 5 trainingen per week.';
                $fee += $settings->getExtraTrainingFee();
                $subscriptionItemExtraTraining = SubscriptionItem::make(
                    $this->subscriptionItemRepository->nextIdentity(),
                    SubscriptionItemType::EXTRA_TRAINING,
                    $itemName,
                    $settings->getExtraTrainingFee(),
                    $subscription
                );
                $subscriptionItemExtraTraining->setSequence($sequence);
                $this->subscriptionItemRepository->save($subscriptionItemExtraTraining);
            }

            if ($subscription->isReductionFamily()) {
                ++$sequence;
                $itemName = 'Gezinskorting lidmaatschap: ' . $settings->getFamilyDiscount() . '%.';
                $reduction = -floatval($settings->getFamilyDiscount()) * $fee / 100;
                $subscriptionItemReduction = SubscriptionItem::make(
                    $this->subscriptionItemRepository->nextIdentity(),
                    SubscriptionItemType::REDUCTION,
                    $itemName,
                    $reduction,
                    $subscription
                );
                $subscriptionItemReduction->setSequence($sequence);
                $this->subscriptionItemRepository->save($subscriptionItemReduction);
            }
        } else {
            ++$sequence;
            $itemName = 'Lopend lidmaatschap van '
                . $this->_format($subscription->getMemberSubscriptionStart()) . ' tot '
                . $this->_format($subscription->getMemberSubscriptionEnd()) . ' (betaald).';
            $subscriptionItemMembership = SubscriptionItem::make(
                $this->subscriptionItemRepository->nextIdentity(),
                SubscriptionItemType::MEMBERSHIP,
                $itemName,
                0,
                $subscription
            );
            $subscriptionItemMembership->setSequence($sequence);
            $this->subscriptionItemRepository->save($subscriptionItemMembership);
        }

        //  -- new membership welcome package --------------------------------------------------------------------------

        if ($subscription->isNewMember()) {
            ++$sequence;
            $itemName = 'Inschrijvingspakket (judogids, judopaspoort, leskaart en sportzak).';
            $welcomeItem = SubscriptionItem::make(
                $this->subscriptionItemRepository->nextIdentity(),
                SubscriptionItemType::SUBSCRIPTION_WELCOME,
                $itemName,
                $settings->getNewMemberSubscriptionFee(),
                $subscription
            );
            $welcomeItem->setSequence($sequence);
            $this->subscriptionItemRepository->save($welcomeItem);
        }

        // -- license item ---------------------------------------------------------------------------------------------

        if ($subscription->isLicenseIsPartSubscription()) {
            ++$sequence;
            $itemName = 'Vergunning ' . mb_strtoupper($federation->getName()) . ' van '
                . $this->_format($subscription->getLicenseStart()) . ' tot '
                . $this->_format($subscription->getLicenseEnd()) . '.';

            $subscriptionItemLicense = SubscriptionItem::make(
                $this->subscriptionItemRepository->nextIdentity(),
                SubscriptionItemType::LICENSE,
                $itemName,
                $federation->getYearlySubscriptionFee(),
                $subscription
            );
            $subscriptionItemLicense->setSequence($sequence);
            $this->subscriptionItemRepository->save($subscriptionItemLicense);
        } else {
            ++$sequence;
            $itemName = 'Lopende vergunning ' . mb_strtoupper($federation->getName()) . ' van '
                . $this->_format($subscription->getLicenseStart()) . ' tot '
                . $this->_format($subscription->getLicenseEnd()) . ' (betaald).';
            $subscriptionItemLicense = SubscriptionItem::make(
                $this->subscriptionItemRepository->nextIdentity(),
                SubscriptionItemType::LICENSE,
                $itemName,
                0,
                $subscription
            );
            $subscriptionItemLicense->setSequence($sequence);
            $this->subscriptionItemRepository->save($subscriptionItemLicense);
        }

        return true;
    }

    private function _format(\DateTimeImmutable $date): string
    {
        return $date->format('m/Y');
    }
}
