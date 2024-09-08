import React from "react";
import "./styles.scss";

type ButtonCompProps = {
    className?: string;
    onClick?: () => void;
    disabled?: boolean;
    text: string;
    id?: string;
    name?: string;
    children ?: React.ReactNode;
}

const doNothing = (...props: any) => null;

export const ButtonComponent: React.FC<ButtonCompProps> = ({
    disabled = false,
    className,
    onClick = doNothing,
    text,
    name,
    id,
    children
   }: ButtonCompProps) => {
    return (
        <div className="button-container">
            <button className={`btn ${className}`} id={id} onClick={onClick} name={name} disabled={disabled}>
                {text}
                <div className="cta-inner-element mx-2">
                    {children}
                </div>
            </button>
        </div>
    )
}
