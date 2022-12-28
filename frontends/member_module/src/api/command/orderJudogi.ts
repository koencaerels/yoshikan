import axios from "axios";

export interface OrderJudogiCommand {
    sequence: Array<number>;
}

export async function orderJudogi(command: OrderJudogiCommand) {
    const formData = new FormData();
    formData.append('sequence', JSON.stringify(command));
    const response = await axios.post<boolean>('/member/judogi/order', formData);

    return response.data;
}
