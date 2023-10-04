type SubscriptionStatus = {
    NEW: 'nieuw';
    AWAITING_PAYMENT: 'wachtend-op-betaling';
    PAYED: 'betaald';
    COMPLETE: 'afgewerkt';
    CANCELED: 'canceled';
};

export const SubscriptionStatusEnum: SubscriptionStatus = {
    NEW: 'nieuw',
    AWAITING_PAYMENT: 'wachtend-op-betaling',
    PAYED: 'betaald',
    COMPLETE: 'afgewerkt',
    CANCELED: 'canceled',
};

type SubscriptionItemType = {
    LICENSE: 'license';
    MEMBERSHIP: 'membership';
    EXTRA_TRAINING: 'extra-training';
    REDUCTION: 'reduction';
    SUBSCRIPTION_WELCOME: 'subscription-welcome';
    JUDOGI: 'judogi';
    OTHER: 'other';
}

export const SubscriptionItemTypeEnum: SubscriptionItemType = {
    LICENSE: 'license',
    MEMBERSHIP: 'membership',
    EXTRA_TRAINING: 'extra-training',
    REDUCTION: 'reduction',
    SUBSCRIPTION_WELCOME: 'subscription-welcome',
    JUDOGI: 'judogi',
    OTHER: 'other',
}

type SubscriptionType = {
    NEW_SUBSCRIPTION: 'nieuwe-inschrijving';
    RENEWAL_FULL: 'volledige-hernieuwing';
    RENEWAL_MEMBERSHIP: 'hernieuwing-lidmaatschap';
    RENEWAL_LICENSE: 'hernieuwing-vergunning';
}

export const SubscriptionTypeEnum: SubscriptionType = {
    NEW_SUBSCRIPTION: 'nieuwe-inschrijving',
    RENEWAL_FULL: 'volledige-hernieuwing',
    RENEWAL_MEMBERSHIP: 'hernieuwing-lidmaatschap',
    RENEWAL_LICENSE: 'hernieuwing-vergunning',
}
