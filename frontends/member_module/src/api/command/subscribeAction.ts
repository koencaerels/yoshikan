import axios from "axios";

export async function subscribeAction(subscription:any) {
    const formData = new FormData();
    formData.append('subscription', JSON.stringify(subscription));
    const response = await axios.post<boolean>(`/subscribe`, formData);
    return response.data;
}
