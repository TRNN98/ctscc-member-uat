import { lazy } from "react";

const MemberRoute = [
    {
        path: "/logon",
        exact: true,
        component: lazy(() => import("../pages/MemLogin/Memlogin"))
    },
    {
        path: "/register",
        exact: true,
        component: lazy(() => import("../pages/Memregis/Memregis"))
    },
    {
        path: "/forget",
        exact: true,
        component: lazy(() => import("../pages/Memregis/Memregis"))
    },
    {
        path: "/impersonate",
        exact: true,
        component: lazy(() => import("../pages/MemImpersonate/MemInpersonate"))
    },
    {
        path: "/status",
        exact: true,
        auth: true,
        layout: "member",
        component: lazy(() => import("../pages/MemStatus/Memstatus"))
    },
    {
        path: "/share",
        exact: true,
        auth: true,
        layout: "member",
        component: lazy(() => import("../pages/MemShare/MemShare"))
    },
    {
        path: "/loan",
        exact: true,
        auth: true,
        layout: "member",
        component: lazy(() => import("../pages/MemLoan/MemLoan"))
    },
    {
        path: "/loan_statement/:statement",
        exact: true,
        auth: true,
        layout: "member",
        component: lazy(() => import("../pages/MemLoan/MemLoanStatement"))
    },
    {
        path: "/deposit",
        exact: true,
        auth: true,
        layout: "member",
        component: lazy(() => import("../pages/Memdep/Memdep"))
    },
    {
        path: "/dep_statement/:statement",
        exact: true,
        auth: true,
        layout: "member",
        component: lazy(() => import("../pages/Memdep/MemdepStatement"))
    },
    {
        path: "/kep",
        exact: true,
        auth: true,
        layout: "member",
        component: lazy(() => import("../pages/Memkep/Memkep"))
    },
    {
        path: "/coll",
        exact: true,
        auth: true,
        layout: "member",
        component: lazy(() => import("../pages/MemColl/MemColl"))
    },
    {
        path: "/gian",
        exact: true,
        auth: true,
        layout: "member",
        component: lazy(() => import("../pages/MemGian/Memgian"))
    },
    {
        path: "/dividend",
        exact: true,
        auth: true,
        layout: "member",
        component: lazy(() => import("../pages/MemDiv/Memdiv"))
    },
    {
        path: "/password",
        exact: true,
        auth: true,
        layout: "member",
        component: lazy(() => import("../pages/MemPass/Mempass"))
    },
    {
        path: "/crem",
        exact: true,
        auth: true,
        layout: "member",
        component: lazy(() => import("../pages/MemCrem/Memcrem"))
    },
    {
        path: "/test",
        exact: true,
        auth: true,
        layout: "member",
        component: lazy(() => import("../pages/Skeleton/MemStatus"))
    }
];

export default MemberRoute;
