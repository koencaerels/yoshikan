/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";
export async function subscribeAction(subscription:any) {
    const formData = new FormData();
    formData.append('subscription', JSON.stringify(subscription));
    const response = await axios.post<boolean>(`/subscribe`, formData);
    return response.data;
}
