export const useTicketEnums = () => {
    const statuses = ['open', 'in_progress', 'closed'] as const;
    const priorities = ['low', 'medium', 'high'] as const;

    const statusColors: Record<string, string> = {
        open: 'bg-blue-100 text-blue-800',
        in_progress: 'bg-yellow-100 text-yellow-800',
        closed: 'bg-green-100 text-green-800',
    };

    const priorityColors: Record<string, string> = {
        low: 'bg-gray-100 text-gray-800',
        medium: 'bg-orange-100 text-orange-800',
        high: 'bg-red-100 text-red-800',
    };

    return {
        statuses,
        priorities,
        statusColors,
        priorityColors,
    };
};
