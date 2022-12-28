import axios from "axios";

export interface AddJudogiCommand {
    code: string;
    name: string;
    size: string;
    price: number;
}

export async function addJudogi(command: AddJudogiCommand) {
    const formData = new FormData();
    formData.append('judogi', JSON.stringify(command));
    const response = await axios.post<boolean>('/member/judogi/add', formData);
    return response.data;
}
