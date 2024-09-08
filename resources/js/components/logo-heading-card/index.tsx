// Signup.tsx
import React from 'react';
import logoIcon from "@images/news-logo.webp";
import './styles.scss';

type ComponentPropTypes = {
    heading: string;
    children ?: React.ReactNode;
}

export const LogoHeadingCardComponent: React.FC<ComponentPropTypes> = ({heading, children}:ComponentPropTypes) => {
    return (
        <div className="card-component-container d-flex justify-content-center">
            <div className="card-container card-block col-12 p-4">
                <div className="heading py-3 d-flex justify-content-between align-items-center">
                    <h3 className="m-0">{heading}</h3>
                    <img src={logoIcon as string} alt="brand-logo" className="icon-logo" />
                </div>
                <div className="d-grid col-12">
                    {children}
                </div>
            </div>
        </div>
    );
};
