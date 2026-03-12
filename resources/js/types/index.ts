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