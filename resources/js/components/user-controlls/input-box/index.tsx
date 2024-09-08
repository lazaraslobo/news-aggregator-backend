import React, {useEffect, useState} from "react";
import "./styles.scss";

type InputBoxProps = {
    type: "text" | "password" | "email" | "password_confirmation";
    className?: string;
    value: string;
    onChange?: (e: React.ChangeEvent<HTMLInputElement>) => void;
    onBlur?: (e: React.ChangeEvent<HTMLInputElement>) => void;
    onFocus?: (e: React.FocusEvent<HTMLInputElement>) => void;
    placeholder: string;
    id?: string;
    name?: string;
    label?: string;
    required?: boolean;
    isError?: boolean;
}

const doNothing = (...props) => null;

export const InputBoxComponent: React.FC<InputBoxProps> = ({
    type = "text",
    className,
    value = "",
    onChange = doNothing,
    onBlur = doNothing,
    onFocus = doNothing,
    placeholder,
    id,
    name,
    isRequired = true,
    label = 'This field is required',
    isError = false
}: InputBoxProps) => {

    const [hasError, setHasError] = useState<boolean>();

    useEffect(()=> setHasError(isError), [isError]);

    const handleOnBlur = (e: React.FocusEvent<HTMLInputElement>) => {
        setHasError(isRequired && e.target.value.trim() === "");
        if (onBlur) {
            onBlur(e);
        }
    };

    return (
        <div className="input-container">
            <span className={`label ${hasError ? 'd-block' : 'd-none'}`}>{label}</span>
            <input
                className={`form-control ${className}`}
                type={type}
                value={value}
                onChange={onChange}
                onBlur={handleOnBlur}
                onFocus={onFocus}
                placeholder={placeholder}
                id={id}
                name={name}
            />
        </div>
    )
}
