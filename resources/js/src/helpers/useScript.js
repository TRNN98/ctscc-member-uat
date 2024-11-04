import { useEffect } from "react";

export const useScript = url => {
    useEffect(() => {
        const script = document.createElement("script");

        script.src = url;
        script.async = false;
        // script.defer = true;

        document.body.appendChild(script);

        return () => {
            document.body.removeChild(script);
        };
    }, [url]);
};
