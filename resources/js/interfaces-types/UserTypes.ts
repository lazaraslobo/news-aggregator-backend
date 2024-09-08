type CreateAccountInnertType = {
    label: string,
    value: string,
    hasError: boolean,
}

export type CreateAccountType = {
    fullName: CreateAccountInnertType;
    email: CreateAccountInnertType;
    password: CreateAccountInnertType;
}
