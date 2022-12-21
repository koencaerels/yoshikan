import axios from "axios";

export interface AddGradeCommand {
    code: string;
    name: string;
    color: string;
}

export async function addGrade(command: AddGradeCommand) {
    const formData = new FormData();
    formData.append('grade', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/grade/add`, formData);
    return response.data;
}
