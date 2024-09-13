// Signup.tsx
import React, {useState} from 'react';
import {ProgressComponent} from "@components/progress";
import {InputBoxComponent} from "@components/user-controlls/input-box";
import {ButtonComponent} from "@components/user-controlls/button";
import pagePaths from "@page-paths";
import { Link} from "react-router-dom";
import {CreateAccountType} from "@interfaces-types/UserTypes";
import logoIcon from "@images/news-logo.webp";
import {LogoHeadingCardComponent} from "@components/logo-heading-card";
import './styles.scss';

const defaultInputsValue: CreateAccountType = {
    fullName: {
        label: "Enter Name",
        value: "",
        hasError: false
    },
    email: {
        label: "Enter Email",
        value: "",
        hasError: false
    },
    password: {
        label: "Enter Password",
        value: "",
        hasError: false
    }
}

export const SignupPage: React.FC = () => {

    const [userInputs, setUserInputs] = useState<CreateAccountType>(defaultInputsValue)

    const handleInputChanges = (key: keyof CreateAccountType, value: string) => setUserInputs({...userInputs, [key]: {...userInputs[key], value}});

    const handleCreateAccount = () => {
        let hasErrors = false;
        const updatedInputs = { ...userInputs };

        // Loop through keys and update the inputs object
        Object.keys(userInputs).forEach((eachKey) => {
            const key = eachKey as keyof CreateAccountType;
            if (userInputs[key].value === "") {
                hasErrors = true;
                updatedInputs[key] = { ...userInputs[key], hasError: true };
            }
        });

        // Update the state once with the new inputs
        setUserInputs(updatedInputs);
        console.log("here ", updatedInputs);
    }

    return (
        <div className="signup-page-container d-flex justify-content-center">
            <div className="col-md-6 col-lg-5 col-xl-4">
                <LogoHeadingCardComponent heading="SIGN UP">
                    <div className="d-grid my-2">
                        <InputBoxComponent
                            placeholder="Full Name"
                            type="text"
                            label="Enter Name"
                            onChange={e => handleInputChanges('fullName', e.target.value)}
                            value={userInputs.fullName.value}
                            isError={userInputs.fullName.hasError}
                        />
                    </div>
                    <div className="d-grid my-2">
                        <InputBoxComponent
                            placeholder="Email" type="email" label="Enter Email"
                            onChange={e => handleInputChanges('email', e.target.value)}
                            isError={userInputs.email.hasError}
                            value={userInputs.email.value}
                        />
                    </div>
                    <div className="d-grid my-2">
                        <InputBoxComponent placeholder="Password" type="password" label="Enter Password"
                                           onChange={e => handleInputChanges('password', e.target.value)}
                                           value={userInputs.password.value}
                                           isError={userInputs.password.hasError}
                        />
                    </div>
                    <div className="d-flex justify-content-between align-items-center mt-4">
                        <Link to={pagePaths.LOGIN_PAGE} className="login-cta-link">Existing User?</Link>
                        <ButtonComponent text="CREATE ACCOUNT" className="cta-signup btn-info d-flex"
                                         onClick={handleCreateAccount}>
                            <ProgressComponent progressType="border" color="warning" width={1} height={1}/>
                        </ButtonComponent>
                    </div>
                </LogoHeadingCardComponent>
            </div>
        </div>
    );
};
