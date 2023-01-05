import axios from "axios";

export interface MarkSubscriptionsAsFinishedCommand {
    listIds: Array<number>;
}

export async function markSubscriptionsAsFinished(command: MarkSubscriptionsAsFinishedCommand) {
    const formData = new FormData();
    formData.append('list-ids', JSON.stringify(command));
    const response = await axios.post<boolean>(`/subscription/mark-as-finished`, formData);
    return response.data;
}
