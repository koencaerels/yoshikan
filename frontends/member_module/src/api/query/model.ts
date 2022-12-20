export interface Configuration {
    grades: Grade[];
    locations: Location[];
    groups: Group[];
    periods: Period[];
    activePeriod: Period;
    settings: Settings;
}

export interface Settings {
    id: number;
    uuid: string;
    code: string;
    yearlyFee2Training: number;
    yearlyFee1Training: number;
    halfYearlyFee2Training: number;
    halfYearlyFee1Training: number;
    extraTrainingFee: number;
    newMemberSubscriptionFee: number;
    familyDiscount: number;
}

export interface Grade {
    id: number;
    uuid: string;
    code: string;
    name: string;
    color: string;
}

export interface Group {
    id: number;
    uuid: string;
    code: string;
    name: string;
    minAge: number;
    maxAge: number;
}

export interface Location {
    id: number;
    uuid: string;
    code: string;
    name: string;
}

export interface Period {
    id: number;
    uuid: string;
    code: string;
    name: string;
    startDate: Date;
    endDate: Date;
    isActive: boolean;
}
