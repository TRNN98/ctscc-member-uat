import { lazy } from "react";

const InfoRoute = [
    {
        path: "/home",
        exact: true,
        layout: "info",
        component: lazy(() => import("../pages/Home/Home"))
    },
    {
        path: "/list/:topicId",
        exact: true,
        layout: "info",
        component: lazy(() => import("../pages/List/List"))
    },
    {
        path: "/download",
        exact: true,
        layout: "info",
        component: lazy(() => import("../pages/List/ListDownload"))
    },
    {
        path: "/show/:topicId",
        exact: true,
        layout: "info",
        component: lazy(() => import("../pages/Show/Show"))
    },
    {
        path: "/board",
        exact: true,
        layout: "info",
        component: lazy(() => import("../pages/Board/Board"))
    },
    {
        path: "/boardPost",
        exact: true,
        layout: "info",
        component: lazy(() => import("../pages/Board/Board_post"))
    },
    {
        path: "/boardShow/:topicId",
        exact: true,
        layout: "info",
        component: lazy(() => import("../pages/Board/Board_show"))
    },
    {
        path: "/procedure",
        exact: true,
        layout: "info",
        component: lazy(() => import("../pages/Show/ShowProcedure"))
    },
    {
        path: "/test",
        exact: true,
        layout: "info",
        component: lazy(() => import("../pages/Skeleton/Home"))
    }
];

export default InfoRoute;
