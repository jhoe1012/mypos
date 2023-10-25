export class Payment {
    label: string;
    identifier: string;
    selected: boolean;
    readonly: boolean;
    value: number;
    total?: number; // LCABORNAY
    change?: number; // LCABORNAY
    id?: number;
}