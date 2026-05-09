import type { User } from './auth';
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
export type Team = {
    id: number;
    name: string;
    users: User[];
};
export interface Deliverable {
    id?: number;
    name: string;
    offset_days: number;
    pivot?: {
        due_date: string;
        missed_due_date_count: number;
    };
}

export interface Course {
    id?: number;
    prefix: string;
    number: string;
    title: string;
    status: string;
    users: User[];
    development_cycle: DevelopmentCycle;
    deliverables: {
        id: number;
        name: string;
        pivot: {
            course_id: number;
            deliverable_id: number;
            due_date: string;
            is_done: boolean;
            date_completed: string | null;
            missed_due_date_count: number;
        };
    }[];
    notes?: string;
}
