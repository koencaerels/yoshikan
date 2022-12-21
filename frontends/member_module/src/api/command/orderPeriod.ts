import axios from "axios";

export interface OrderPeriodCommand {
    sequence: Array<number>;
}

export async function orderPeriod(command: OrderPeriodCommand) {
    const formData = new FormData();
    formData.append('sequence', JSON.stringify(command));
    const response = await axios.post<boolean>('/member/period/order', formData);

    return response.data;
}
