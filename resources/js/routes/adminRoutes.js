import {
    ProductList,
    ForgetPassword,
    ResetPassword,
    Dashboard,
    Notfound,
    Customers,
    Category,
    Settings,
    LandingPage,
    Orders,
    OrderDetails,
    AdminSignin,
    AdminSignup,
} from "../admin/pages";
import { ADMIN_ROLES } from "../constant";

export const adminRoutes = [
    {
        path: "",
        name: "admin-signin",
        component: AdminSignin,
        meta: {
            requireAuth: false,
        },
    },
    {
        path: "signup",
        name: "admin-signup",
        component: AdminSignup,
        meta: {
            requireAuth: false,
        },
    },
    {
        path: "admin/forget-password",
        name: "forget",
        component: ForgetPassword,
        meta: {
            requireAuth: false,
        },
    },
    {
        path: "admin/reset-password",
        name: "reset",
        component: ResetPassword,
        meta: {
            requireAuth: false,
        },
    },

    {
        path: "dashboard",
        name: "admin-dashboard",
        component: Dashboard,
        meta: {
            requireAuth: true,
            roles:ADMIN_ROLES
        },
    },
    {
        path: "customers",
        name: "customers",
        component: Customers,
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "orders",
        name: "orders",
        component: Orders,
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "order-details/:id",
        name: "order-details",
        component: OrderDetails,
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "category",
        name: "category",
        component: Category,
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "category/:id",
        name: "product",
        component: ProductList,
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "landing",
        name: "landing",
        component: LandingPage,
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "settings",
        name: "settings",
        component: Settings,
        meta: {
            requireAuth: true,
        },
    },
];
