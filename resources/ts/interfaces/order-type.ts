export interface OrderType { 
    identifier: 'takeaway' | 'delivery' | 'dinein'; 
    label: string;
    selected: boolean;
    icon: string;
};