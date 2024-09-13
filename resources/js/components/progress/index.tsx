import React from "react";

type propType = {
    color: "primary" | "success" | "info" | "warning" | "danger";
    progressType: "border" | "grow",
    width: number,
    height: number,
}

export const ProgressComponent: React.FC<propType> = ({color, progressType, width = 0.5, height=0.5}: propType) => {
    return (
        <div className={`spinner-${progressType} text-${color}`} role="status" style={{
            width: `${width}rem`,
            height: `${height}rem`,
        }}>
            <span className="visually-hidden">Loading...</span>
        </div>
    )
}
