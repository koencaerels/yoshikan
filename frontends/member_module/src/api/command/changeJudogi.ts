import axios from "axios";

export interface ChangeJudogiCommand {
    id: number;
    code: string;
    name: string;
    size: string;
    price: string;
}

export async function changeJudogi(command: ChangeJudogiCommand) {
    const formData = new FormData();
    formData.append('judogi', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/judogi/${command.id}`, formData);
    return response.data;
}
