import axios from "axios";

export interface AddPeriodCommand {
    code: string;
    name: string;
    startDate: Date;
    endDate: Date;
}

export async function addPeriod(command: AddPeriodCommand) {
    const formData = new FormData();
    formData.append('period', JSON.stringify(command));
    const response = await axios.post<boolean>('/member/period/add', formData);
    return response.data;
}
