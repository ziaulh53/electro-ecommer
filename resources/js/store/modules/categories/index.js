import { defineStore } from "pinia";
import { api, categoryEndpoint } from "../../../api";

export const useCategoryStore = defineStore("category", {
  state: () => ({
    category:  [],
  }),
  getters: {
    allCategories: (state) => state.category,
  },
  actions: {
    async fetchCateogries() {
     const res = await api.get(categoryEndpoint.fetchCategory);
     if(res.success){
        this.category = res?.result || [];
     }
    },
  },
});
