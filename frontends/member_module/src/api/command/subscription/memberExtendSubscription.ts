import axios from "axios";
import type {Judogi} from "@/api/query/model";

export interface MemberExtendSubscriptionCommand {
    memberId: number;
    federationId: number;
    locationId: number;

    contactFirstname: string;
    contactLastname: string;
    contactEmail: string;
    contactPhone: string;

    firstname: string;
    lastname: string;
    dateOfBirth: Date;
    gender: string;

    type: string;
    memberSubscriptionStart: Date;
    memberSubscriptionStartMM: string;
    memberSubscriptionStartYY: string;
    memberSubscriptionEnd: Date;
    memberSubscriptionTotal: number;
    memberSubscriptionIsPartSubscription: boolean;
    memberSubscriptionIsHalfYear: boolean;

    licenseStart: Date;
    licenseStartMM: string;
    licenseStartYY: string;
    licenseEnd: Date;
    licenseTotal: number;
    licenseIsPartSubscription: boolean;

    numberOfTraining: number;
    isExtraTraining: boolean;
    isNewMember: boolean;
    isReductionFamily: boolean;

    total: number;
    remarks: string;

    isJudogiBelt: boolean;
    judogi?: Judogi;
}

export async function memberExtendSubscription(command: MemberExtendSubscriptionCommand) {
    const formData = new FormData();
    formData.append('group', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/${command.memberId}/subscribe`, formData);
    return response.data;
}
