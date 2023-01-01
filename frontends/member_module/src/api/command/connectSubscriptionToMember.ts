import axios from "axios";

export interface ConnectSubscriptionToMemberCommand {
    id: number;
    memberId: number;
}

export async function connectSubscriptionToMember(command: ConnectSubscriptionToMemberCommand) {
    const formData = new FormData();
    formData.append('connect-member', JSON.stringify(command));
    const response = await axios.post<boolean>(`/subscription/${command.id}/connect-member`, formData);
    return response.data;
}
