// Signup.tsx
import React from 'react';
import './styles.scss';
import {ProgressComponent} from "@components/progress";
import {InputBoxComponent} from "@components/user-controlls/input-box";
import {ButtonComponent} from "@components/user-controlls/button";
import pagePaths from "@page-paths";
import { Link } from "react-router-dom";
import {LogoHeadingCardComponent} from "@components/logo-heading-card";

export const LoginPage: React.FC = () => {
    return (
        <div className="login-page-container d-flex justify-content-center">
            <div className="col-md-6 col-lg-5 col-xl-4">
                <LogoHeadingCardComponent heading="LOGIN">
                    <div className="d-grid my-2">
                        <InputBoxComponent placeholder="Email" type="email" label="Enter Email"/>
                    </div>
                    <div className="d-grid my-2">
                        <InputBoxComponent placeholder="Password" type="password" label="Enter Password"/>
                    </div>
                    <div className="d-flex justify-content-between align-items-center mt-4">
                        <Link to={pagePaths.SIGNUP_PAGE} className="login-cta-link">Existing User?</Link>
                        <ButtonComponent text="LOGIN" className="cta-login btn-primary d-flex">
                            <ProgressComponent progressType="border" color="warning" width={1} height={1}/>
                        </ButtonComponent>
                    </div>
                </LogoHeadingCardComponent>
            </div>
        </div>
);
};
