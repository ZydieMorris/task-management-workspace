export type Position ={
    id: number;
    position_name: string;
    created_at: string;
    updated_at: string;
}


export type Project ={
    id: number;
    project_name: string;
    project_description: string;
    project_severity: string;
    deployment_date: string;
    created_at: string;
    updated_at: string;
}

export type User = {
    id: number;
    name: string;
    email: string;
    role: string;
    position: string;
    created_at: string;
    updated_at: string;
}


