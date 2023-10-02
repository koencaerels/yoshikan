/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from "axios";
import type {Configuration} from "@/api/query/model";
import type {DashboardNumbers} from "@/api/query/reportModel";

export async function getDashboardNumbers() {
    const response = await axios.get<DashboardNumbers>(`/get-dashboard-numbers`);
    return response.data;
}
