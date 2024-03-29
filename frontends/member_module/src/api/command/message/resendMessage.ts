/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";

export interface ResendMessageCommand {
    messageId: number;
    toEmail: string;
}

export async function resendMessage(command: ResendMessageCommand) {
    const formData = new FormData();
    formData.append('command', JSON.stringify(command));
    const response = await axios.post<boolean>(`/message/${command.messageId}/resend`, formData);
    return response.data;
}
