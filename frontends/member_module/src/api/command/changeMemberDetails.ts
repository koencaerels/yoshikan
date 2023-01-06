import axios from "axios";

export interface ChangeMemberDetailsCommand {
    id: number;
    status: string;
    firstname: string;
    lastname: string;
    dateOfBirth: Date;
    gender: string;
    locationId: number;
}

export async function changeMemberDetails(command: ChangeMemberDetailsCommand) {
    const formData = new FormData();
    formData.append('command', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/${command.id}/change-details`, formData);
    return response.data;
}
