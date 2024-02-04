export const auth = {
    login: '/signin',
    reg: '/signup',
    logout: '/signout',
    forgetPassword: '/auth/forget-password',
    resetPassword: '/auth/reset-password',
    editProfile: '/auth/edit-profile',
    changePassword: '/auth/change-password',
    changeEmailRequest: '/auth/change-email-request',
    changeEmail: '/auth/change-email'
}

export const categoryEndpoint = {
    fetchCategory: '/category',
    fetchSingleCategory: '/category/',
}
export const productEndpoint = {
    fetchSingleProduct: '/product/',
    fetchSuggestionProducts: '/product/suggestion',
    fetchNewArrival: '/product/new-arrival',
    fetchProductOnBrand: '/product/brands/',
}

export const landingEndpoint = {
    fetchHomepage: '/landing',
    getAllbrands: "/landing/brands"
}

export const orderEndpoint = {
    getOrders: '/order',
    createOrder: '/order/create',
    getSingleOrder: '/order/',
    updateStatus: '/order/update-status/'
}

export const wishEndpoint = {
    getWishItems: '/wish',
    addWish: '/wish/create',
}

export const addressEndpoint = {
    getAddress: '/address',
    createAddress: '/address/create',
    editAddress: '/address/edit/',
    deleteAddress: '/address/delete/',
}