import axios from "axios";

export async function deleteMemberImage(id: number) {
    const response = await axios.delete<boolean>(`/member/member-image/${id}/delete`);
    return response.data;
}
