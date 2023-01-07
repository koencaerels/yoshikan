/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
