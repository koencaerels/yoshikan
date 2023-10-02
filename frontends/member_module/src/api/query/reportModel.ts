/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import type {Federation, Location, Period} from "@/api/query/model";

export interface DashboardNumbers {
    activePeriod: Period;
    federationReports: Array<FederationReport>;
    locationReports: Array<LocationReport>;
    activeMembers: number;
    duePayments: number;
    totalAmount: number;
}

export interface FederationReport {
    federation: Federation;
    locationReports: Array<LocationReport>;
    activeMembers: number;
    duePayments: number;
    totalAmount: number;
}

export interface LocationReport {
    location: Location;
    activeMembers: number;
    duePayments: number;
    totalAmount: number;
}
