export type UseDateUtilsReturn = {
    daysLate: (due_date: any) => number;
};

export function daysLate(due_date: any): number {
    const dueDate = new Date(due_date);
    const today = new Date();
    const timeDiff = today.getTime() - dueDate.getTime();
    return Math.ceil(timeDiff / (1000 * 3600 * 24));
}

export function useDateUtils(): UseDateUtilsReturn {
    return { daysLate };
}
