/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface newMemberSubscriptionCommand {

    type: string;
    federationId: number;
    locationId: number;

    contactFirstname: string;
    contactLastname: string;
    contactEmail: string;
    contactPhone: string;

    addressStreet: string;
    addressNumber: string;
    addressBox: string;
    addressZip: string;
    addressCity: string;

    firstname: string;
    lastname: string;
    email: string;
    nationalRegisterNumber: string;
    dateOfBirth: Date;
    gender: string;

    memberSubscriptionStart: Date;
    memberSubscriptionStartMM: string;
    memberSubscriptionStartYY: string;
    memberSubscriptionEnd: Date;
    memberSubscriptionTotal: number;
    memberSubscriptionIsPartSubscription: boolean;
    memberSubscriptionIsHalfYear: boolean;
    memberSubscriptionIsPayed: boolean;

    licenseStart: Date;
    licenseStartMM: string;
    licenseStartYY: string;
    licenseEnd: Date;
    licenseTotal: number;
    licenseIsPartSubscription: boolean;
    licenseIsPayed: boolean;

    numberOfTraining: number;
    isExtraTraining: boolean;
    isNewMember: boolean;
    isReductionFamily: boolean;

    total: number;
    remarks: string;

    isJudogiBelt: boolean;
}

export async function newMemberSubscription(command: newMemberSubscriptionCommand) {
    const formData = new FormData();
    formData.append('command', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/new-subscription`, formData);
    return response.data;
}
