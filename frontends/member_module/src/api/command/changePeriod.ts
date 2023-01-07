/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface ChangePeriodCommand {
    id: number;
    code: string;
    name: string;
    startDate: Date;
    endDate: Date;
    isActive: boolean;
}

export async function changePeriod(command: ChangePeriodCommand) {
    const formData = new FormData();
    formData.append('period', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/period/${command.id}`, formData);
    return response.data;
}
