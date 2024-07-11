/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface SaveSettingsCommand {
    code: string;
    yearlyFee2Training: string;
    yearlyFee1Training: string;
    halfYearlyFee2Training: string;
    halfYearlyFee1Training: string;
    extraTrainingFee: string;
    newMemberSubscriptionFee: string;
    newMemberSubscriptionFeeWithoutGuide: string;
    familyDiscount: string;
}

export async function saveSettings(command: SaveSettingsCommand) {
    const formData = new FormData();
    formData.append('settings', JSON.stringify(command));
    const response = await axios.post<boolean>(`/member/settings`, formData);
    return response.data;
}
