import axios from "axios";

export interface ChangeMemberRemarksCommand {
    id: number;
    remarks: string;
}

export async function changeMemberRemarks(command: ChangeMemberRemarksCommand) {
    const formData = new FormData();
    formData.append('command', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/${command.id}/change-remarks`, formData);
    return response.data;
}
