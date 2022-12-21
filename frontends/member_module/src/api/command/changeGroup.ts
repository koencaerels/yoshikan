import axios from "axios";

export interface ChangeGroupCommand {
    id: number;
    code: string;
    name: string;
    minAge: string;
    maxAge: string;
}

export async function changeGroup(command: ChangeGroupCommand) {
    const formData = new FormData();
    formData.append('group', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/group/${command.id}`, formData);
    return response.data;
}
