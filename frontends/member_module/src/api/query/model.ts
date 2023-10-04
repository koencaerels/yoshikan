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
    publicLabel: string;
}

export interface Subscription {
    // -- attributes
    id: number;
    uuid: string;
    status: string;
    type: string;
    memberId: number;
    messageId: number;
    contactFirstname: string;
    contactLastname: string;
    contactEmail: string;
    contactPhone: string;
    firstname: string;
    lastname: string;
    dateOfBirth: Date;
    gender: string;
    numberOfTraining: number;
    isExtraTraining: boolean;
    isNewMember: boolean;
    isReductionFamily: boolean;
    isJudogiBelt: boolean;
    remarks: string;
    total: number;
    settings: string;
    isPaymentOverviewSend: boolean;
    nationalRegisterNumber: string;
    addressStreet: string;
    addressNumber: string;
    addressBox: string;
    addressZip: string;
    addressCity: string;
    memberSubscriptionStart: Date;
    memberSubscriptionEnd: Date;
    memberSubscriptionTotal: number;
    memberSubscriptionIsPartSubscription: boolean;
    licenseStart: Date;
    licenseEnd: Date;
    licenseTotal: number;
    licenseIsPartSubscription: boolean;
    // -- associations
    member: Member;
    location: Location;
    federation: Federation;
    subscriptionItems: SubscriptionItem[];
}

export interface SubscriptionItem {
    id: number;
    uuid: string;
    sequence: number;
    type: string;
    name: string;
    price: number;
}

export interface Member {
    // -- attributes
    id: number;
    uuid: string;
    status: string;
    firstname: string;
    lastname: string;
    dateOfBirth: Date;
    gender: string;
    nationalRegisterNumber: string;
    email: string;
    addressStreet: string;
    addressNumber: string;
    addressBox: string;
    addressZip: string;
    addressCity: string;
    remarks: string;
    profileImage: string;
    memberSubscriptionStart: Date;
    memberSubscriptionEnd: Date;
    memberSubscriptionIsPayed: boolean;
    memberSubscriptionIsHalfYear: boolean;
    licenseStart: Date;
    licenseEnd: Date;
    licenseIsPayed: boolean;
    contactFirstname: string;
    contactLastname: string;
    contactEmail: string;
    contactPhone: string;
    numberOfTraining: number;
    // -- associations
    grade: Grade;
    location: Location;
    federation: Federation;
    subscriptions?: Subscription[];
    gradelogs: GradeLog[];
    memberImages: MemberImage[];
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

export interface Message {
    id: number;
    uuid: string;
    sendOn: Date;
    fromName: string;
    fromEmail: string;
    toName: string;
    toEmail: string;
    subject: string;
    message: string;
    member?: Member;
    subscription?: Subscription;
}
