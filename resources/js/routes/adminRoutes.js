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
    Products,
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
        name: "admin-forget",
        component: ForgetPassword,
        meta: {
            requireAuth: false,
        },
    },
    {
        path: "admin/reset-password",
        name: "admin-reset",
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
        name: "admin-customers",
        component: Customers,
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "orders",
        name: "admin-orders",
        component: Orders,
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "order-details/:id",
        name: "admin-order-details",
        component: OrderDetails,
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "product",
        name: "admin-product",
        component: Products,
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "category",
        name: "admin-category",
        component: Category,
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "category/:id",
        name: "admin-single-category",
        component: ProductList,
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "landing",
        name: "admin-landing",
        component: LandingPage,
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "settings",
        name: "admin-settings",
        component: Settings,
        meta: {
            requireAuth: true,
        },
    },
];
