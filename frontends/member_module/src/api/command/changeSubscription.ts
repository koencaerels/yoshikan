import axios from "axios";

export interface ChangeSubscriptionCommand {
    id: number;
    contactFirstname: string;
    contactLastname: string;
    contactEmail: string;
    contactPhone: string;
    firstname: string;
    lastname: string;
    dateOfBirthDD: string;
    dateOfBirthMM: string;
    dateOfBirthYYYY: string;
    dateOfBirth: Date;
    gender: string;
    newMember: boolean;
    locationId: number;
    type: string;
    numberOfTraining: number;
    extraTraining: boolean;
    reductionFamily: boolean;
    judogiBelt: boolean;
    remarks: string;
}

export async function changeSubscription(command: ChangeSubscriptionCommand) {
    const formData = new FormData();
    formData.append('subscription', JSON.stringify(command));
    const response = await axios.post<boolean>(`/subscription/${command.id}`, formData);
    return response.data;
}
