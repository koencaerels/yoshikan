import axios from "axios";

export interface OrderGradeCommand {
    sequence: Array<number>;
}

export async function orderGrade(command: OrderGradeCommand) {
    const formData = new FormData();
    formData.append('sequence', JSON.stringify(command));
    const response = await axios.post<boolean>('/member/grade/order', formData);

    return response.data;
}
