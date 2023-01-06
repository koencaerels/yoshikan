import axios from "axios";
import type {Grade} from "@/api/query/model";

export interface ChangeMemberGradeCommand {
    id: number;
    grade: Grade;
}

export async function changeMemberGrade(command: ChangeMemberGradeCommand) {
    const formData = new FormData();
    formData.append('command', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/${command.id}/change-grade`, formData);
    return response.data;
}
