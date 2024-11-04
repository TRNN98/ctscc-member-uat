import { useEffect } from 'react';

export const useStyle = url => {
  useEffect( () => {
    const link = document.createElement('link');

    link.rel = "stylesheet";
    link.href = url;
    link.async = false;

    document.head.appendChild(link);

    return () => {
      document.head.removeChild(link);
    }
  }, [url]);
};
