import axios from "axios";

export interface ChangeSubscriptionStatusCommand {
    id: number;
    status: string;
}

export async function changeSubscriptionStatus(command: ChangeSubscriptionStatusCommand) {
    const formData = new FormData();
    formData.append('change-status', JSON.stringify(command));
    const response = await axios.post<boolean>(`/subscription/${command.id}/change-status`, formData);
    return response.data;
}
