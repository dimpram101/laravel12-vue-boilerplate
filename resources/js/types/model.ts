import { Role } from ".";

export type User = {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    created_at?: string;
    updated_at?: string;
    permission: any;
    roles: Role[];
};
export enum RoleEnum {
    SUPER_ADMIN = "super-admin",
    ADMIN = "admin",
    USER = "user",
    KAPRODI = "kaprodi",
    DOSEN = "dosen"
}
