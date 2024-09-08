import React from 'react';
import ReactDOM from 'react-dom/client';
import { RouterProvider } from 'react-router-dom';
import { router } from './routes/routes';
import "@scss/app.scss";

const App: React.FC = () => {
    return (
        <div className="container">
            <RouterProvider router={router} />
        </div>
    );
};

const rootElement = document.getElementById("app-root");
if (!rootElement) {
    throw new Error("Failed to find the root element.");
}

const root = ReactDOM.createRoot(rootElement);
root.render(
    <React.StrictMode>
        <App />
    </React.StrictMode>
);
