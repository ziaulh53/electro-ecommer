import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../store";
import { clientRoutes } from "./clientRoutes";
import { adminRoutes } from "./adminRoutes";
import { AdminPanel } from "../admin/pages";
import { ADMIN_ROLES } from "../constant";

const routes = [
    ...clientRoutes.map((route) => ({
        ...route,
        meta: { ...route.meta, isAdmin: false },
    })),
    {
        path: "/admin",
        component: AdminPanel,
        children: adminRoutes.map((route) => ({
            ...route,
            meta: { ...route.meta, isAdmin: true },
        })),
        meta: {
            isAdmin: true,
        },
    },
];

// const isAuthenticated = JSON.parse(localStorage.getItem("auth"))?.isAuthenticated;

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const userStore = useAuthStore();
    const { isAuthenticated, user } = userStore.user;

    if(!isAuthenticated && to.meta.requireAuth){
        if(to.meta.isAdmin){
            next('/admin');
        } else {
            next('/signin');
        }
    } else if (isAuthenticated){
        if(ADMIN_ROLES.includes(user?.role) && (!to.meta.requireAuth || !to.meta.isAdmin)){
            next('/admin/dashboard');
        } else if(user.role==='user' && (("requireAuth" in to.meta && !to.meta.requireAuth) || to.meta.isAdmin)) {
            next('/');
        } else next();
    } else next();

});

export default router;
