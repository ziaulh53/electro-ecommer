import { createRouter, createWebHistory } from "vue-router";
import {
  Home,
  CategoryDetails,
  SignUp,
  SignIn,
  ShoppingCart,
  Checkout,
  ForgetPassword,
  ResetPassword,
  ProductDetails,
  TrendingsDetails,
  OrderConfirmation,
  StockOut,
  Account,
  NewEmailVerify,
  OrderDetails,
  Brand
} from "../client/pages";
import { useAuthStore } from "../store";

const routes = [
  {
    path: "/",
    name: "home",
    component: Home,
  },
  {
    path: "/category/:id",
    name: "category",
    component: CategoryDetails,
  },
  {
    path: "/product/:id",
    name: "product",
    component: ProductDetails,
  },
  {
    path: "/trending",
    name: "trending",
    component: TrendingsDetails,
  },
  {
    path: "/brands/:id",
    name: "brand",
    component: Brand,
  },
  {
    path: "/shopping-cart",
    name: "shopping",
    component: ShoppingCart,
  },
  {
    path: "/signup",
    name: "signup",
    component: SignUp,
    meta: {
      requireAuth: false,
    },
  },
  {
    path: "/signin",
    name: "signin",
    component: SignIn,
    meta: {
      requireAuth: false,
    },
  },
  {
    path: "/forget-password",
    name: "forget",
    component: ForgetPassword,
    meta: {
      requireAuth: false,
    },
  },
  {
    path: "/reset-password",
    name: "reset",
    component: ResetPassword,
    meta: {
      requireAuth: false,
    },
  },
  {
    path: "/change-email-verification",
    name: "new-email-verification",
    component: NewEmailVerify,
    meta: {
      requireAuth: false,
    },
  },
  {
    path: "/checkout",
    name: "checkout",
    component: Checkout,
    meta: {
      requireAuth: true,
    },
  },
  {
    path: "/order-confirmation",
    name: "order-confirmation",
    component: OrderConfirmation,
    meta: {
      requireAuth: true,
    },
  },
  {
    path: "/stock-out",
    name: "stock-out",
    component: StockOut,
    meta: {
      requireAuth: true,
    },
  },
  {
    path: "/account",
    name: "account",
    component: Account,
    meta: {
      requireAuth: true,
    },
  },
  {
    path: "/order-details/:id",
    name: "order-details",
    component: OrderDetails,
    meta: {
      requireAuth: true,
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
  const { isAuthenticated } = userStore.user;
  if ("requireAuth" in to.meta && to.meta.requireAuth && !isAuthenticated) {
    next("/signin");
  } else if (
    "requireAuth" in to.meta &&
    !to.meta.requireAuth &&
    isAuthenticated
  ) {
    next("/");
  } else next();
});

export default router;
