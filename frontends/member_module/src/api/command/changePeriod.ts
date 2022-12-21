import axios from "axios";

export interface ChangePeriodCommand {
    id: number;
    name: string;
    startDate: Date;
    endDate: Date;
    isActive: boolean;
}

export async function changePeriod(command: ChangePeriodCommand) {
    const formData = new FormData();
    formData.append('period', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/period/add/${command.id}`, formData);
    return response.data;
}
