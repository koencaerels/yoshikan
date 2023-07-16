import type {Member} from "@/api/query/model";
import moment from "moment";

export function memberStatusColor(member: Member): string {
    let color: string = 'bg-green-200';
    let today: number = parseInt(moment().format('YYYYMM'));

    if (member.memberSubscriptionIsPayed) {
        let end: number = parseInt(moment(member.memberSubscriptionEnd).format('YYYYMM'));
        if (end <= today) {
            color = 'bg-yellow-200';
        }
    } else {
        color = 'bg-red-200';
    }

    return color;
}

export function showMemberSubscriptionExtendButton(member: Member): boolean {

    let today: number = parseInt(moment().format('YYYYMM'));
    let end: number = parseInt(moment(member.memberSubscriptionEnd).format('YYYYMM'));

    return (end <= today);

}
