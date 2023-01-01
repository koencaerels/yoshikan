export interface Configuration {
    grades: Grade[];
    locations: Location[];
    groups: Group[];
    periods: Period[];
    judogi: Judogi[];
    activePeriod: Period;
    settings: Settings;
}

export interface Settings {
    id: number;
    uuid: string;
    code: string;
    yearlyFee2Training: string;
    yearlyFee1Training: string;
    halfYearlyFee2Training: string;
    halfYearlyFee1Training: string;
    extraTrainingFee: string;
    newMemberSubscriptionFee: string;
    familyDiscount: string;
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
    minAge: string;
    maxAge: string;
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

export interface Judogi {
    id: number;
    uuid: string;
    code: string;
    name: string;
    size: string;
    price: string;
}

export interface Subscription {
    id: number;
    uuid: string;
    status: string;
    contactFirstname: string;
    contactLastname: string;
    contactEmail: string;
    contactPhone: string;
    firstname: string;
    lastname: string;
    dateOfBirth: Date;
    gender: string;
    type: string;
    numberOfTraining: number;
    isExtraTraining: boolean;
    isNewMember: boolean;
    isReductionFamily: boolean;
    isJudogiBelt: boolean;
    judogiPrice: string;
    remarks: string;
    total: string;
    period: Period;
    location: Location;
    judogi?: Judogi;
    settings: Settings;
    isPaymentOverviewSend:boolean;
}
