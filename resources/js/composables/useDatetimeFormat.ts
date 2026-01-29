export const useDatetimeFormat = () => {
    /**
     * Pad number with leading zero (e.g., 5 -> "05")
     */
    const pad = (num: number): string => {
        return String(num).padStart(2, '0');
    };

    /**
     * Format date to DD.MM.YYYY format (e.g., "28.01.2026")
     */
    const formatDate = (date: string | Date): string => {
        const d = new Date(date);
        const day = pad(d.getDate());
        const month = pad(d.getMonth() + 1);
        const year = d.getFullYear();
        return `${day}.${month}.${year}`;
    };

    /**
     * Format time to HH:mm format (e.g., "23:42")
     */
    const formatTime = (date: string | Date): string => {
        const d = new Date(date);
        const hours = pad(d.getHours());
        const minutes = pad(d.getMinutes());
        return `${hours}:${minutes}`;
    };

    /**
     * Format date and time to DD.MM.YYYY HH:mm format (e.g., "28.01.2026 23:42")
     */
    const formatDateTime = (date: string | Date): string => {
        return `${formatDate(date)} ${formatTime(date)}`;
    };

    return {
        formatDate,
        formatTime,
        formatDateTime,
    };
};