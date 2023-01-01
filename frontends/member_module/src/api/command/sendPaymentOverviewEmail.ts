import axios from "axios";

export async function sendPaymentOverviewEmail(id:number) {
    const response = await axios.post<boolean>(`/subscription/${id}/mail-payment-information`);
    return response.data;
}
