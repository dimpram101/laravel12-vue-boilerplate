export type ProfileUpdateRequest = {
    name: string;
    email: string;
};
export type LoginRequest = {
    email: string;
    password: string;
};
export type CreateUserRequest = {
    name: string;
    email: string;
    password: string;
    role: string;
};
