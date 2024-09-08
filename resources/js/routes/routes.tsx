import { createBrowserRouter } from "react-router-dom";
import {LoginPage} from "@pages/login";
import {SignupPage} from "@pages/singup";
import pagePaths from "@page-paths";

export const router = createBrowserRouter([
    {
        path: pagePaths.LOGIN_PAGE,
        element: <LoginPage />,
    },
    {
        path: pagePaths.SIGNUP_PAGE,
        element: <SignupPage />,
    },
]);
