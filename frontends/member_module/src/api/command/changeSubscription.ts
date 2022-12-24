export interface changeSubscriptionCommand {
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
