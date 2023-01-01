import axios from "axios";

export async function createMemberFromSubscription(id: number) {
    const response = await axios.post<boolean>(`/subscription/${id}/create-member`);
    return response.data;
}
