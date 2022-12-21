import axios from "axios";

export interface ChangeLocationCommand {
    id: number;
    code: string;
    name: string;
}

export async function changeLocation(command: ChangeLocationCommand) {
    const formData = new FormData();
    formData.append('location', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/location/add/${command.id}`, formData);
    return response.data;
}
