import { defineStore } from "pinia";
import { api, brandAdmin } from "../../../api";

export const useBrandStore = defineStore("brand", {
  state: () => ({
    brands: [],
  }),
  getters: {
    brand: (state) => state.brands,
  },
  actions: {
   
    async saveBrands() {
      try {
        const res = await api.get(brandAdmin.getBrands);
        if (res.success) {
          this.brands = res.brands?.data;
        }
      } catch (error) {
        console.log(error);
      }
    },
    
  },
});
