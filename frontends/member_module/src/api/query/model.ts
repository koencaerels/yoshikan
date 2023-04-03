/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
export interface Configuration {
    grades: Grade[];
    locations: Location[];
    groups: Group[];
    periods: Period[];
    judogi: Judogi[];
    federations: Federation[];
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

export interface Federation {
    id: number;
    uuid: string;
    sequence: number;
    code: string;
    name: string;
    yearlySubscriptionFee: number;
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
    isPaymentOverviewSend: boolean;
    member?: Member;
    selected: boolean;
    nationalRegisterNumber: string;
    addressStreet: string;
    addressNumber: string;
    addressBox: string;
    addressZip: string;
    addressCity: string;
}

export interface Member {
    id: number;
    uuid: string;
    status: string;
    firstname: string;
    lastname: string;
    dateOfBirth: Date;
    gender: string;
    grade: Grade;
    location: Location;
    remarks: string;
    subscriptions?: Subscription[];
    gradeLogs: GradeLog[];
    images: MemberImage[];
    profileImage: string;
    nationalRegisterNumber: string;
    addressStreet: string;
    addressNumber: string;
    addressBox: string;
    addressZip: string;
    addressCity: string;
    email: string;

    //-- subscription and license details

    memberSubscriptionStart: Date;
    memberSubscriptionEnd: Date;
    memberSubscriptionIsPayed: boolean;
    licenseStart: Date;
    licenseEnd: Date;
    licenseIsPayed: boolean;
    federation: Federation;
}

export interface GradeLog {
    id: number;
    uuid: string;
    date: Date;
    remark: string;
    fromGrade: Grade;
    toGrade: Grade;
}

export interface MemberImage {
    id: number;
    uuid: string;
    originalName: string;
}
