import axios from "axios";

export interface ChangeGradeCommand {
    id: number;
    code: string;
    name: string;
    color: string;
}

export async function changeGrade(command: ChangeGradeCommand) {
    const formData = new FormData();
    formData.append('grade', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/grade/${command.id}`, formData);
    return response.data;
}
