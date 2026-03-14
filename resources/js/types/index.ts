import { User } from './auth';
export * from './auth';
export * from './navigation';
export * from './ui';
export interface AdminSetting {
    key: string;
    value: string | number | null;
}
export interface DevelopmentCycle {
    id?: number;
    name: string;
    start_date: string | null;
    end_date: string | null;
}

export interface Deliverable {
    id?: number;
    name: string;
    offset_days: number;
}

export interface Course {
    id?: number;
    prefix: string;
    number: string;
    name: string;
    users: (User & { pivot: { role: string; [key: string]: any } })[];
    development_cycle: DevelopmentCycle;
    deliverables: Deliverable[];
}
