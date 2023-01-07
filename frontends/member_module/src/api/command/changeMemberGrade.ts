/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";
import type {Grade} from "@/api/query/model";

export interface ChangeMemberGradeCommand {
    id: number;
    grade: Grade;
    remark: string;
}

export async function changeMemberGrade(command: ChangeMemberGradeCommand) {
    const formData = new FormData();
    formData.append('command', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/${command.id}/change-grade`, formData);
    return response.data;
}
