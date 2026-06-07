export type TaskStatus =  | 'To Do'
    | 'In Progress'
    | 'For Checking'
    | 'On Hold'
    | 'Completed';

export type TaskPriority = 'low' | 'medium' | 'high';

export type Task ={
    id: number;
    task_name: string;
    task_description: string;
    task_status: TaskStatus;
    task_priority: TaskPriority;
    task_deadline: string;
    assign_to: string;
    created_at: string;
    updated_at: string;
}
