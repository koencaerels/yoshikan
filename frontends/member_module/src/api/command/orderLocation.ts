import axios from "axios";

export interface OrderLocationCommand {
    sequence: Array<number>;
}

export async function orderLocation(command: OrderLocationCommand) {
    const formData = new FormData();
    formData.append('sequence', JSON.stringify(command));
    const response = await axios.post<boolean>('/member/location/order', formData);

    return response.data;
}
