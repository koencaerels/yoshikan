import type {Member} from "@/api/query/model";
import moment from "moment/moment";

export function licenseStatusColor(member: Member): string {

    let color: string = 'bg-green-200';
    let today: number = parseInt(moment().format('YYYYMM'));

    if (member.licenseIsPayed) {
        let end: number = parseInt(moment(member.licenseEnd).subtract(1, 'months').format('YYYYMM'));
        if (end <= today) {
            color = 'bg-yellow-200';
        }
    } else {
        color = 'bg-red-200';
    }

    return color;
}

export function showLicenseExtendButton(member: Member): boolean {

    let today: number = parseInt(moment().format('YYYYMM'));
    let end: number = parseInt(moment(member.licenseEnd).subtract(1, 'months').format('YYYYMM'));

    return (end <= today);

}
