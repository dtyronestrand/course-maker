export type UseDateUtilsReturn = {
    daysLate: (dueDate: string | number | Date) => number;
};

export function daysLate(dueDate: string | number | Date): number {
    const parsedDueDate = new Date(dueDate);
    const today = new Date();
    const timeDiff = today.getTime() - parsedDueDate.getTime();
    return Math.ceil(timeDiff / (1000 * 3600 * 24));
}

export function useDateUtils(): UseDateUtilsReturn {
    return { daysLate };
}
